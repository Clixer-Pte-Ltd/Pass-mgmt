<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Models\BackpackUser as User;
use App\Imports\SubContructorsImport;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\StoreSubConstructorRequest as StoreRequest;
use App\Http\Requests\UpdateSubConstructorRequest as UpdateRequest;
use App\Imports\SubContructorAccountsImport;

/**
 * Class SubConstructorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubConstructorCrudController extends CrudController
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
        $this->crud->setModel('App\Models\SubConstructor');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/sub-constructor');
        $this->crud->setEntityNameStrings('Sub Contractor', 'Sub Contractors');
        $this->crud->allowAccess('show');
        $this->crud->addButtonFromView('line', 'show', 'manage', 'beginning');
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

        // add asterisk for fields that are required in SubConstructorRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        // Overwrite view
        $this->crud->setShowView('crud::sub-constructor.show');
        $this->crud->setCreateView('crud::sub-constructor.create');
        $this->crud->setEditView('crud::sub-constructor.edit');
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
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
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereRaw("DATE_FORMAT(tenancy_start_date, \"%m %d %Y\") like ? ", "%" . $searchTerm . "%");
            }
        ]);
        $this->crud->addColumn([
            'name' => 'tenancy_end_date', // The db column name
            'label' => 'Tenancy End Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereRaw("DATE_FORMAT(tenancy_end_date, \"%m %d %Y\") like ? ", "%" . $searchTerm . "%");
            }
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

        if (session()->has(SESS_TENANT_SUB_CONSTRUCTOR) || session()->has(SESS_TENANT_MY_COMPANY)) {
            if (session()->has(SESS_TENANT_SUB_CONSTRUCTOR)) {
                $value = session()->get(SESS_TENANT_SUB_CONSTRUCTOR);
            } else {
                if (backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE])) {
                    $value = session()->get(SESS_TENANT_MY_COMPANY);
                } else {
                    $value = backpack_user()->subConstructor->tenant_id;
                }
            }
            $this->crud->addField([
                'label' => 'Tenant',
                'name' => 'tenant_id',
                'type' => 'hidden',
                'value' => $value
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
    }

    public function setupFilters()
    {
        //filter
        $this->crud->addFilter([ // daterange filter
            'type' => 'date_range',
            'name' => 'date_end_range',
            'label'=> 'Sub Contractor End Date Range'
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'tenancy_end_date', '>=', $dates->from);
                $this->crud->addClause('where', 'tenancy_end_date', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->addFilter([ // date filter
            'type' => 'date',
            'name' => 'date',
            'label'=> 'Sub Contractor End Date Pickup'
        ],
            false,
            function($value) {
                $this->crud->addClause('where', 'tenancy_end_date', $value);
            });

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'name',
            'label'=> 'Name'
        ]);

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'uen',
            'label'=> 'Uen'
        ]);
    }

    public function index()
    {
        $content = parent::index();
        session()->forget(SESS_TENANT_SUB_CONSTRUCTOR);
        if (!backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE])) {
            $this->crud->addButtonFromView('top', 'import_sub_constructors', 'import_sub_constructors', 'end');
        }

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
        return redirect()->back();
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
        session()->forget(SESS_NEW_ACC_FROM_TENANT);
        session()->put(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR, $id);

        $content = parent::show($id);
        $this->crud->removeColumn('role_id');
        $this->crud->removeColumn('tenant_id');
        $this->crud->addColumn([  // Select2
            'name' => 'tenant.name',
            'label' => 'Tenant',
            'type' => 'text'
        ]);

        if (backpack_user()->hasRole(COMPANY_CO_ROLE)) {
            $this->crud->removeButtonFromStack('update', 'line');
        }

//        $this->crud->addButtonFromView('line', 'add_account', 'add_account', 'end');
        return $content;
    }

    public function newAccount($id)
    {
        session()->put('add_account', true);
        session()->forget(SESS_NEW_ACC_FROM_TENANT);
        session()->put(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR, $id);

        return redirect()->route('backpack.auth.register');
    }

    public function account2fa($sub_constructor_id, $id)
    {
        session()->put(SESS_SUB_CONSTRUCTOR_2FA, $sub_constructor_id);
        session()->forget(SESS_TENANT_2FA);

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
        $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw");
        $result = array($request->file('import_file')->getClientOriginalExtension());

        if (!in_array($result[0],$extensions)) {
            \Alert::error('You must choose excel file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }
//        $excel->import(new SubContructorsImport, $request->file('import_file'));

        $import = new SubContructorsImport();
        $import->import($request->file('import_file'));
        if ($import->failures()->count() || count($import->error)) {
            return view('errors.error_import', ['failures' => $import->failures(), 'errors' => $import->error]);
        }
        \Alert::success('Import successful.')->flash();

        return redirect()->route('crud.sub-constructor.index');
    }

    public function importDemo()
    {
        $file = public_path() . '/exports/sub-constructors.xlsx';
        return response()->download($file);
    }

    public function importAccount(Request $request, Excel $excel)
    {
        if (is_null($request->file('import_file'))) {
            \Alert::error('You must choose file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }
        $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw");
        $result = array($request->file('import_file')->getClientOriginalExtension());

        if (!in_array($result[0],$extensions)) {
            \Alert::error('You must choose excel file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }
//        $excel->import(new SubContructorAccountsImport, $request->file('import_file'));
        $import = new SubContructorAccountsImport();
        $import->import($request->file('import_file'));
        if ($import->failures()->count() || count($import->error)) {
            return view('errors.error_import', ['failures' => $import->failures(), 'errors' => $import->error]);
        }

        \Alert::success('Import successful. Email will be sent out to imported accounts soon...')->flash();

        return redirect()->route('crud.sub-constructor.index');
    }

    public function importAccountDemo()
    {
        $file = public_path() . '/exports/sub_constructor_accounts.xlsx';
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
}
