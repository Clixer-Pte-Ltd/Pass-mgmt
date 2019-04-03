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
        $this->setupColumns();
        $this->setupFilters();

        // add asterisk for fields that are required in ExpiredCompanyRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->addButtonFromView('line', 'renew', 'renew_company');
        $this->crud->removeButton('update');
        $this->crud->setListView('crud::customize.list');
        $this->crud->removeButtonFromStack('create', 'top');
        if (backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE])) {
            $this->crud->denyAccess('delete');
            $this->crud->denyAccess('update');
        }
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
            'name' => 'type',
            'label' => 'type',
            'type' => 'closure',
            'function' => function($entry) {
                return getTypeAttribute($entry->type);
            }
        ]);
        $this->crud->addColumn([
            'name' => 'tenancy_start_date', // The db column name
            'label' => 'Tenancy Start Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value,
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

    public function setupFilters()
    {
        //filter
        $this->crud->addFilter([ // daterange filter
            'type' => 'date_range',
            'name' => 'date_end_range',
            'label'=> 'Company End Date Range'
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'tenancy_end_date', '>=', $dates->from);
                $this->crud->addClause('where', 'tenancy_end_date', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->addFilter([ // date filter
            'type' => 'date',
            'name' => 'date_end_pickup',
            'label'=> 'Company End Date Pickup'
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

        $this->crud->addFilter([ // custom filter view
            'name' => 'type',
            'type' => 'view',
            'view' => 'vendor.backpack.crud.filters.radio', // or path to blade file
            'label'=> 'Type',
        ], [
            'Tenant' => 'App\Models\Tenant',
            'SubConstructor' => 'App\Models\SubConstructor'
        ], function($value) {
            $this->crud->addClause('where', 'type', $value);
        });
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

    public function destroy($uen)
    {
       $this->crud->getEntry($uen)->companyable->delete();
    }


    public function renew($uen)
    {
        $this->crud->addField([
            'name' => 'tenancy_end_date',
            'type' => 'date_picker',
            'label' => 'Tenancy End Date'
        ]);
        $content = parent::edit($uen);
        return $content;
    }

    public function updateExpiry(RenewRequest $request)
    {
        $this->crud->getEntry($request->uen)->companyable->update(['tenancy_end_date' => $request->tenancy_end_date, 'status' => COMPANY_STATUS_WORKING]);
        return redirect()->route('crud.expired-company.index');
    }
}
