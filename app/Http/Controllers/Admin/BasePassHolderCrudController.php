<?php

namespace App\Http\Controllers\Admin;

// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\StorePassHolderRequest as StoreRequest;
use App\Http\Requests\UpdatePassHolderRequest as UpdateRequest;

/**
 * Class PassHolderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BasePassHolderCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('companyOwner')->only(['edit', 'update', 'store','destroy']);
        $this->middleware('hasRoles:' . implodeCag([CAG_ADMIN_ROLE, CAG_STAFF_ROLE, COMPANY_CO_ROLE, COMPANY_AS_ROLE]))->only(['edit', 'create','update', 'store','destroy', 'import']);

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

        //List columns
        $this->crud->addColumns(['applicant_name', 'nric']);
        $this->crud->addColumn([
            'name' => 'pass_expiry_date', // The db column name
            'label' => 'Pass Expiry Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value
        ]);

        $this->crud->addColumn([
            'name' => 'company.name',
            'label' => 'Company',
            'type' => 'text'
        ]);

        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
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
            'label' => 'NRIC'
        ]);

        $this->crud->addField([
            'name' => 'pass_expiry_date',
            'type' => 'date_picker',
            'label' => 'Pass Expiry Date'
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
        ]);
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->addButtonFromView('top', 'import_pass_holders', 'import_pass_holders', 'end');
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
}
