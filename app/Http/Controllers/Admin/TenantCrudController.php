<?php

namespace App\Http\Controllers\Admin;

use App\Models\BackpackUser as User;
use Illuminate\Http\Request;
// VALIDATION: change the requests to match your own file names if you need form validation
use Maatwebsite\Excel\Excel;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\StoreTenantRequest as StoreRequest;
use App\Http\Requests\UpdateTenantRequest as UpdateRequest;
use App\Imports\TenantsImport;
use App\Imports\TenantAccountsImport;

/**
 * Class TenantCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TenantCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Tenant');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tenant');
        $this->crud->setEntityNameStrings('tenant', 'tenants');
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

        // add asterisk for fields that are required in TenantRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        // Overwrite view
        $this->crud->setShowView('crud::tenant.show');
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->addButtonFromView('top', 'import_tenants', 'import_tenants', 'end');
        $this->crud->addButtonFromView('top', 'import_tenant_accounts', 'import_tenant_accounts', 'end');
        return $content;
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        session()->put('tenant', $this->crud->entry->id);
        session()->forget('sub_constructor');

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

        session()->put(SESS_TENANT_SUB_CONSTRUCTOR, $id);

        $content = parent::show($id);
        $this->crud->removeColumn('role_id');
        $this->crud->addButtonFromView('line', 'add_account', 'add_account', 'end');
        $this->crud->addButtonFromView('line', 'add_sub_constructor', 'add_sub_constructor', 'end');
        return $content;
    }

    public function newAccount($id)
    {
        session()->put('tenant', $id);
        session()->forget('sub_constructor');

        return redirect()->route('backpack.auth.register');
    }

    public function newSubConstructor($id)
    {
        return redirect()->route('crud.sub-constructor.create');
    }

    public function account2fa($tenant_id, $id)
    {
        session()->put('tenant_2fa', $tenant_id);
        session()->forget('sub_constructor_2fa');

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

    public function import(Request $request, Excel $excel)
    {
        $excel->import(new TenantsImport, $request->file('import_file'));

        \Alert::success('Import successful.')->flash();

        return redirect()->route('crud.tenant.index');
    }

    public function importDemo()
    {
        $file = public_path() . '/exports/tenants.xlsx';
        return response()->download($file);
    }

    public function importAccount(Request $request, Excel $excel)
    {
        $excel->import(new TenantAccountsImport, $request->file('import_file'));

        \Alert::success('Import successful. Email will be sent out to imported accounts soon...')->flash();

        return redirect()->route('crud.tenant.index');
    }

    public function importAccountDemo()
    {
        $file = public_path() . '/exports/accounts.xlsx';
        return response()->download($file);
    }
}
