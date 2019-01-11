<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ExpiredCompanyRequest as StoreRequest;
use App\Http\Requests\ExpiredCompanyRequest as UpdateRequest;

/**
 * Class ExpiredCompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ExpiredCompanyCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\ExpiredCompany');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/expired-company');
        $this->crud->setEntityNameStrings('Expired Company', 'Expired Companies');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        $this->crud->addColumns(['name', 'uen']);
        $this->crud->addColumn([
            'name' => 'type', // The db column name
            'label' => 'Type', // Table column heading
            'type' => 'text',
        ]);
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

        // add asterisk for fields that are required in ExpiredCompanyRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->removeAllButtonsFromStack('line');
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
    }

    public function index()
    {
        $content = parent::index();
        return $content->with('hideCreatePanel', true);
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
