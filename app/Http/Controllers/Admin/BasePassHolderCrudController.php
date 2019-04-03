<?php

namespace App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Controllers\Backpack\CRUD\CrudController;
use App\Http\Requests\StorePassHolderRequest as StoreRequest;
use App\Http\Requests\UpdatePassHolderRequest as UpdateRequest;
use App\Traits\Export;


/**
 * Class PassHolderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BasePassHolderCrudController extends CrudController
{
    use Export;

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
        $this->crud->setModel('App\Models\PassHolder');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();
        $this->setupColumns();

//        $this->crud->addButtonFromView('top', 'export excel', 'export_excel', 'end');
//        $this->crud->addButtonFromView('top', 'export pdf', 'export_pdf', 'end');
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
        $this->crud->allowAccess('show');
        if (backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE])) {
            $this->crud->denyAccess('delete');
            $this->crud->denyAccess('update');
        }
        $this->crud->setShowView('crud::pass-holders.show');
        $this->crud->enableExportButtons();
    }
    public function setupColumns()
    {
        //List columns
        $this->crud->addColumn([
            'name' => 'applicant_name',
            'label' => 'Name',
            'type' => 'text',
            'searchLogic' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'nric',
            'label' => 'Pass Number',
            'type' => 'closure',
            'function' => function ($entry) {
                if (backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE]) && $entry->nric) {
                    return encodeNric($entry->nric);
                }
                return $entry->nric;
            },
            'searchLogic' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'pass_expiry_date', // The db column name
            'label' => 'Pass Expiry Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value,
            'searchLogic' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'country.name',
            'label' => 'Country',
            'type' => 'text',
            'visibleInTable' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'company.name',
            'label' => 'Company',
            'type' => 'text',
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('company', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            }
        ]);

        $this->crud->addColumn([
            'name' => 'ru_name',
            'label' => 'RU Name',
            'type' => 'text',
            'visibleInTable' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'ru_email',
            'label' => 'RU Email',
            'type' => 'text',
            'visibleInTable' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'as_name',
            'label' => 'AS Name',
            'type' => 'text',
            'visibleInTable' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'as_email',
            'label' => 'AS Email',
            'type' => 'text',
            'visibleInTable' => false,
        ]);

        $this->crud->addColumn([
            // n-n relationship (with pivot table)
            'label' => 'Zones', // Table column heading
            'type' => 'select_multiple',
            'name' => 'zones', // the method that defines the relationship in your Model
            'entity' => 'zones', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Zone", // foreign key model,
            'visibleInTable' => false,
        ]);
    }
    protected function addRequired()
    {
        // add asterisk for fields that are required in StorePassHolderRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    protected function addFields()
    {
        //FORM FIELDS
        $this->crud->addField([
            'name' => 'applicant_name',
            'type' => 'text',
            'label' => 'Applicant Name'
        ]);

        $this->crud->addField([
            'name' => 'nric',
            'type' => 'text',
            'label' => 'Pass Number',
            'attributes' => backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE]) &&  \Route::current()->getName() == "crud.tenant-pass-holder.edit" ?
                ['readonly'=>'readonly', 'disabled'=>'disabled'] : []
        ]);

        $this->crud->addField([
            'name' => 'pass_expiry_date',
            'type' => 'date_picker',
            'label' => 'Pass Expiry Date',
            'attributes' => backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE]) &&  \Route::current()->getName() == "crud.tenant-pass-holder.edit" ?
                ['readonly'=>'readonly', 'disabled'=>'disabled'] : []
        ]);

        $this->crud->addField([  // Select2
            'label' => 'Country',
            'type' => 'select2',
            'name' => 'country_id', // the db column for the foreign key
            'entity' => 'country', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Country", // foreign key model,
        ]);

        $this->crud->addField([  // Select2
            'label' => 'Company',
            'type' => 'select2',
            'name' => 'company_uen', // the db column for the foreign key
            'entity' => 'company', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Company", // foreign key model,
        ]);

        $this->crud->addField([
            'name' => 'ru_name',
            'type' => 'text',
            'label' => 'RU Name'
        ]);

        $this->crud->addField([
            'name' => 'ru_email',
            'type' => 'text',
            'label' => 'RU Email'
        ]);

        $this->crud->addField([
            'name' => 'as_name',
            'type' => 'text',
            'label' => 'AS Name'
        ]);

        $this->crud->addField([
            'name' => 'as_email',
            'type' => 'text',
            'label' => 'AS Email'
        ]);

        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => 'Zones',
            'type' => 'select2_multiple',
            'name' => 'zones', // the method that defines the relationship in your Model
            'entity' => 'zones', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Zone", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            'select_all' => true, // show Select All and Clear buttons?
            'attributes' => backpack_user()->hasAnyRole([COMPANY_CO_ROLE, COMPANY_AS_ROLE]) &&  \Route::current()->getName() == "crud.tenant-pass-holder.edit" ?
                ['readonly'=>'readonly', 'disabled'=>'disabled'] : []
        ]);
    }

    public function index()
    {
        $content = parent::index();
        if (!backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE])) {
            $this->crud->addButtonFromView('top', 'import_pass_holders', 'import_pass_holders', 'end');
        }
        return $content;
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return redirect()->route('crud.pass-holder.index');
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function filterExport($passHolders)
    {
        $exportData = [];
        foreach ($passHolders as $pass) {
            $countryName = $pass->country->name;
            $pass = $pass->toArray();
            unset($pass['country_id']);
            unset($pass['status']);
            $pass['zones'] = $pass['zones'] ? implodeCag(array_column($pass['zones'], 'name')) : '';
            $pass['country'] = $countryName;
            $pass['nric'] = backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE]) ? encodeNric($pass['nric']) : $pass['nric'];
            $pass['pass_expiry_date'] = custom_date_format($pass['pass_expiry_date']);
            $pass['created_at'] = custom_date_time_format($pass['created_at']);
            $pass['updated_at'] = custom_date_time_format($pass['updated_at']);

            $exportData[] = $pass;
        }
        return collect($exportData);
    }
}
