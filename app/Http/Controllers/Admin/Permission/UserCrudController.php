<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Models\BackpackUser;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BaseUserCrudController;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use App\Models\Role;
use App\User;
use Carbon\Carbon;
use App\Models\Company;
use App\Events\CompanyAddAccount;
use Illuminate\Support\Collection;

class UserCrudController extends BaseUserCrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('crudUser');
    }
    public function setup()
    {
        parent::setup();
        $this->crud->addClause('whereNotIn', 'id', [backpack_user()->id]);
        if (backpack_user()->hasRole(COMPANY_CO_ROLE) && backpack_user()->hasCompany()) {
            $ids = backpack_user()->getCompany()->first()->getAllAccounts()->pluck('id')->toArray();
            $this->crud->addClause( 'whereIn', 'id', $ids);
        }
        $this->crud->addColumn([
                'name' => 'company',
                'label' => 'Company',
                'type' => 'closure',
                'function' => function($entry) {
                    if ($entry->hasCompany()) {
                        if ($entry->getCompany() instanceof Collection) {
                            $name = implode(' ; ', $entry->getCompany()->pluck('name')->toArray());
                        } else {
                            $name = $entry->getCompany()->name;
                        }
                    } else {
                        $name = null;
                    }

                    return $name;
                }
            ]);
        $this->crud->removeColumn('permissions');
        $this->crud->addColumn('phone');
        $this->crud->removeField('roles_and_permissions');
        $this->crud->addField([
            'label' => 'Phone',
            'name' => 'phone',
            'type' => 'text'
        ]);
        $this->crud->addField([
            'label' => trans('backpack::permissionmanager.roles'),
            'type' => 'closure_ratio',
            'name' => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => config('permission.models.role'), // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
            'number_columns' => 3, //can be 1,2,3,4,6
            'function' => function() {
                if (backpack_user()->hasRole(COMPANY_CO_ROLE)) {
                    return Role::whereIn('name', config('backpack.company.roles'))->get();
                }
                if (backpack_user()->hasRole(CAG_ADMIN_ROLE)) {
                    return Role::all();
                }
            }
        ]);
//        if (backpack_user()->hasCompany()) {
//            $this->crud->addField([
//                'name' => backpack_user()->tenant ? 'tenant_id' : 'sub_constructor_id',
//                'type' => 'hidden',
//                'value' => backpack_user()->getCompany()->id
//            ]);
//        }

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'name',
            'label'=> 'Name'
        ]);

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'email',
            'label'=> 'Email'
        ]);

        $roles = backpack_user()->hasAnyRole(config('backpack.cag.roles')) ?
            Role::pluck('name', 'id')->toArray() :
            Role::whereIn('name', config('backpack.company.roles'))->pluck('name', 'id')->toArray();
        $this->crud->addFilter([ // dropdown filter
            'name' => 'roles',
            'type' => 'dropdown',
            'label'=> 'Roles'
        ], $roles, function($value) {
            $usersId = BackpackUser::whereHas('roles', function ($query) use ($value) {
                $query->where('id', $value);
            })->pluck('id')->toArray();
            $this->crud->addClause('whereIn', 'id', $usersId);
        });

        if (backpack_user()->hasAnyRole(config('backpack.cag.roles'))) {
            $companiesName = Company::getAllCompanies()->pluck('name', 'uen')->toArray();
            $this->crud->addFilter([ // dropdown filter
                'name' => 'uen',
                'type' => 'dropdown',
                'label'=> 'Company'
            ], $companiesName, function($value) {
                $ids = Company::where('uen', $value)->first()->companyable->getAllAccounts()->pluck('id')->toArray();
                $this->crud->addClause('whereIn', 'id', $ids);
            });
        }

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'phone',
            'label'=> 'Phone'
        ]);
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
        $this->crud->addButtonFromView('line', 'show_config_2fa', 'show_config_2fa', 'end');
    }

    public function store(StoreRequest $request)
    {
        $request->request->add(['last_modify_password_at' => Carbon::now(), 'token' => uniqid() . str_random(40)]);
        // your additional operations before save here
        parent::storeCrud($request);
        event(new CompanyAddAccount($this->crud->entry));
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return redirect()->route('crud.user.index');
    }

    public function showAccount2fa($id)
    {
        session()->put(SESS_SUB_CONSTRUCTOR_2FA, 0);
        session()->put(SESS_TENANT_2FA, 0);

        $account = User::findOrFail($id);
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Add the secret key to the registration data
        if (!$account->google2fa_secret) {
            $account->google2fa_secret = $google2fa->generateSecretKey();
            $account->save();
        }

        $registration_data['google2fa_secret'] = $account->google2fa_secret;

        // Generate the QR image. This is the image the user will scan with their app
        // to set up two factor authentication
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $account->email,
            $registration_data['google2fa_secret']
        );

        // Pass the QR barcode image to our view
        return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
    }

    public function update(UpdateRequest $request)
    {
        $this->handlePasswordInput($request);
        if ($request->has('password')) {
            $request->request->add(['last_modify_password_at' => Carbon::now()]);
            BackpackUser::find($request->get('id'))->detachNotification(CHANGE_PASSWORD_NOTIFICATION);
        }

        return parent::updateCrud($request);
    }
}
