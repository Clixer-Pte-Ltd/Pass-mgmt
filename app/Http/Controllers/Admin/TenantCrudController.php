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
use App\Models\Tenant;


/**
 * Class TenantCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TenantCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('companyOwner');
    }

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Tenant');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tenant');
        $this->crud->setEntityNameStrings('Tenant', 'Tenants');
        $this->crud->allowAccess('show');
        if (backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE])) {
            $this->crud->denyAccess('delete');
            $this->crud->denyAccess('update');
        }
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();
        $this->setupColumns();
        $this->setupFields();
        $this->setupFilters();

        // add asterisk for fields that are required in TenantRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        // Overwrite view
        $this->crud->setShowView('crud::tenant.show');
        $this->crud->setEditView('crud::tenant.edit');
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
        $this->crud->addButtonFromView('line', 'show', 'manage', 'beginning');
        $this->crud->enableExportButtons();
    }

    public function setupColumns()
    {
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Name',
            'type' => 'closure',
            'function' => function ($entry) {
                return "<a href='" . url($this->crud->route . '/' . $entry->getKey()) . "'>{$entry->name}</a>";
            },
            'searchLogic' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'uen',
            'type' => 'text',
            'label' => 'Company Code',
            'searchLogic' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'tenancy_start_date', // The db column name
            'label' => 'Tenancy Start Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value
            'searchLogic' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'tenancy_end_date', // The db column name
            'label' => 'Tenancy End Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value,
            'searchLogic' => 'text'
        ]);
    }

    public function setupFields()
    {
        $this->crud->addField([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Name'
        ]);

        $this->crud->addField([
            'name' => 'uen',
            'type' => 'text',
            'label' => 'Company Code'
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
    }

    public function setupFilters()
    {
        //filter
        $this->crud->addFilter(
            [ // daterange filter
                'type' => 'date_range',
                'name' => 'date_end_range',
                'label' => 'Tenancy End Date Range'
            ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'tenancy_end_date', '>=', $dates->from);
                $this->crud->addClause('where', 'tenancy_end_date', '<=', $dates->to . ' 23:59:59');
            }
        );

        $this->crud->addFilter(
            [ // date filter
                'type' => 'date',
                'name' => 'date_end_pickup',
                'label' => 'Tenancy End Date Pickup'
            ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'tenancy_end_date', $value);
            }
        );

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'name',
            'label'=> 'Name'
        ]);

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'uen',
            'label'=> 'Company Code'
        ]);
    }

    public function index()
    {
        $content = parent::index();
        if (!backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE])) {
            $this->crud->addButtonFromView('top', 'import_tenants', 'import_tenants', 'end');
            $this->crud->addButtonFromView('top', 'import_tenant_accounts', 'import_tenant_accounts', 'end');
        }
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
        session()->forget(SESS_TENANT_2FA);
        session()->forget(SESS_SUB_CONSTRUCTOR_2FA);
        session()->put(SESS_NEW_ACC_FROM_TENANT, $id);
        session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);

        session()->put(SESS_TENANT_SUB_CONSTRUCTOR, $id);

        $content = parent::show($id);
        $this->crud->removeColumn('role_id');
        $this->crud->addButtonFromView('line', 'add_account', 'add_account', 'end');
        $this->crud->addButtonFromView('line', 'add_sub_constructor', 'add_sub_constructor', 'end');
        return $content;
    }

    public function newAccount($id)
    {
        session()->put('add_account', true);
        session()->put(SESS_NEW_ACC_FROM_TENANT, $id);
        session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);

        return redirect()->route('backpack.auth.register');
    }

    public function newSubConstructor($id)
    {
        return redirect()->route('crud.sub-constructor.create');
    }

    public function account2fa($tenant_id, $id)
    {
        session()->put(SESS_TENANT_2FA, $tenant_id);
        session()->forget(SESS_SUB_CONSTRUCTOR_2FA);

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
        if (is_null($request->file('import_file'))) {
            \Alert::error('You must choose file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }

        $extensions = ['xls', 'xlsx', 'xlm', 'xla', 'xlc', 'xlt', 'xlw'];
        $result = [$request->file('import_file')->getClientOriginalExtension()];

        if (!in_array($result[0], $extensions)) {
            \Alert::error('You must choose excel file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }

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
        if (is_null($request->file('import_file'))) {
            \Alert::error('You must choose file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }
        $extensions = ['xls', 'xlsx', 'xlm', 'xla', 'xlc', 'xlt', 'xlw'];
        $result = [$request->file('import_file')->getClientOriginalExtension()];

        if (!in_array($result[0], $extensions)) {
            \Alert::error('You must choose excel file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }
        $excel->import(new TenantAccountsImport, $request->file('import_file'));

        \Alert::success('Import successful. Email will be sent out to imported accounts soon...')->flash();

        return redirect()->route('crud.tenant.index');
    }

    public function importAccountDemo()
    {
        $file = public_path() . '/exports/tenant_accounts.xlsx';
        return response()->download($file);
    }

    public function validateCompany($id)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = COMPANY_STATUS_WORKING;
        $entry->save();

        $content = parent::show($id);
        $this->crud->removeColumn('role_id');
        $this->crud->addButtonFromView('line', 'add_account', 'add_account', 'end');
        $this->crud->addButtonFromView('line', 'add_sub_constructor', 'add_sub_constructor', 'end');
        \Alert::success('Validate done')->flash();
        return $content;
    }

    public function addUserAs(Request $request)
    {
        $user_as_ids = $request->has('user_as_ids') ? $request->user_as_ids : [];
        if ($request->has('tenant_id')) {
            $entry = $this->crud->getEntry($request->tenant_id);
            $entry->asAccounts()->sync($user_as_ids);
            \Alert::success('Add AS Users done')->flash();
        } else {
            \Alert::error('Error add AS Users')->flash();
        }
        return redirect()->back();
    }

    public function showDetailAjax(Request $request)
    {
        if ($request->ajax() && $request->has('tenant_select_id') && backpack_user()->hasRole(COMPANY_AS_ROLE)) {
            $tenant = Tenant::find($request->tenant_select_id);
            session()->put(SESS_TENANT_SUB_CONSTRUCTOR, $tenant->id);
            return view('partials.company_detail_content', ["entry" => $tenant])->render();
        }
    }
}
