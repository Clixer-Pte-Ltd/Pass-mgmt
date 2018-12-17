<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PassHolderRequest as StoreRequest;
use App\Http\Requests\PassHolderRequest as UpdateRequest;

/**
 * Class PassHolderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PassHolderCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\PassHolder');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/pass-holder');
        $this->crud->setEntityNameStrings('Pass Holder', 'Pass Holders');

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
            'name' => 'country.name',
            'label' => 'Country',
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'company.name',
            'label' => 'Company',
            'type' => 'text'
        ]);
        $this->crud->addColumns(['ru_name', 'ru_email', 'as_name', 'as_email']);
        $this->crud->addColumn([
            // n-n relationship (with pivot table)
            'label' => 'Zones', // Table column heading
            'type' => 'select_multiple',
            'name' => 'zones', // the method that defines the relationship in your Model
            'entity' => 'zones', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Zone", // foreign key model
        ]);

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
            'type' => 'email',
            'label' => 'RU Email'
        ]);

        $this->crud->addField([
            'name' => 'as_name',
            'type' => 'text',
            'label' => 'AS Name'
        ]);

        $this->crud->addField([
            'name' => 'as_email',
            'type' => 'email',
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

        // add asterisk for fields that are required in PassHolderRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
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
