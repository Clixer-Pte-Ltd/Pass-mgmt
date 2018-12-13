<?php

namespace App\Http\Controllers\Admin;

use App\Models\BackpackUser as User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StoreSubConstructorRequest as StoreRequest;
use App\Http\Requests\UpdateSubConstructorRequest as UpdateRequest;

/**
 * Class SubConstructorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubConstructorCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\SubConstructor');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sub-constructor');
        $this->crud->setEntityNameStrings('Sub Constructor', 'Sub Constructors');
        $this->crud->allowAccess('show');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        $this->crud->addColumns(['name', 'uen']);
        $this->crud->addColumn([
            'name' => 'tenancy_start_date', // The db column name
            'label' => 'Tenancy Start Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value
        ]);
        $this->crud->addColumn([
            'name' => 'tenancy_end_date', // The db column name
            'label' => 'Tenancy End Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value
        ]);

        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'
        ]);

        $this->crud->addField([
            'name' => 'uen',
            'type' => 'text',
            'label' => 'UEN'
        ]);

        $this->crud->addField([
            'name' => 'tenancy_start_date',
            'type' => 'date_picker',
            'label' => 'Tenancy Start Date'
        ]);

        $this->crud->addField([
            'name' => 'tenancy_end_date',
            'type' => 'date_picker',
            'label' => 'Tenancy End Date'
        ]);

        if (session()->has(SESS_TENANT_SUB_CONSTRUCTOR)) {
            $this->crud->addField([
                'label' => 'Tenant',
                'name' => 'tenant_id',
                'type' => 'hidden',
                'value' => session()->get(SESS_TENANT_SUB_CONSTRUCTOR)
            ]);
        } else {
            $this->crud->addField([  // Select2
                'label' => 'Tenant',
                'type' => 'select2',
                'name' => 'tenant_id', // the db column for the foreign key
                'entity' => 'tenant', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Tenant", // foreign key model,
            ]);
        }

        // add asterisk for fields that are required in SubConstructorRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        // Overwrite view
        $this->crud->setShowView('crud::sub-constructor.show');
        $this->crud->setCreateView('crud::sub-constructor.create');
        $this->crud->setEditView('crud::sub-constructor.edit');
    }

    public function index()
    {
        $content = parent::index();
        session()->forget(SESS_TENANT_SUB_CONSTRUCTOR);
        return $content;
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        session()->put('sub_constructor', $this->crud->entry->id);
        session()->forget('tenant');
        return redirect()->route('backpack.auth.register');
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function show($id)
    {
        //Reset for 2fa setup
        session()->forget('tenant_2fa');
        session()->forget('sub_constructor_2fa');

        $content = parent::show($id);
        $this->crud->removeColumn('role_id');
        $this->crud->removeColumn('tenant_id');
        $this->crud->addColumn([  // Select2
            'name' => 'tenant.name',
            'label' => 'Tenant',
            'type' => 'text'
        ]);
        $this->crud->addButtonFromView('line', 'add_account', 'add_account', 'end');
        return $content;
    }

    public function newAccount($id)
    {
        session()->forget('tenant');
        session()->put('sub_constructor', $id);

        return redirect()->route('backpack.auth.register');
    }

    public function account2fa($sub_constructor_id, $id)
    {
        session()->put('sub_constructor_2fa', $sub_constructor_id);
        session()->forget('tenant_2fa');

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
