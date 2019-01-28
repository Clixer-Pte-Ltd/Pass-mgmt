<?php

namespace App\Http\Controllers\Admin\Permission;

use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BaseUserCrudController;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use App\Models\Role;
use App\User;

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
        if (backpack_user()->hasRole(COMPANY_CO_ROLE) && backpack_user()->hasCompany()) {
            $companyId = backpack_user()->getCompany()->id;
            $this->crud->addClause(backpack_user()->tenant ? 'whereTenantId' : 'whereSubConstructorId', $companyId);
        }
        $this->crud->addColumn([
                'name' => 'company',
                'label' => 'Company',
                'type' => 'closure',
                'function' => function($entry) {
                    return $entry->hasCompany() ? $entry->getCompany()->name : null;
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
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
        $this->crud->addButtonFromView('line', 'show_config_2fa', 'show_config_2fa', 'end');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
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
}
