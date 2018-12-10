<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TenantRequest as StoreRequest;
use App\Http\Requests\TenantRequest as UpdateRequest;

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

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        $this->crud->addColumns(['name', 'uen', 'tenancy_start_date', 'tenancy_end_date']);

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

        $this->crud->addField([  // Select2
            'label' => 'Role',
            'type' => 'select2',
            'name' => 'role_id', // the db column for the foreign key
            'entity' => 'role', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Role", // foreign key model
        ]);

        // add asterisk for fields that are required in TenantRequest
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
