<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;

class ReturnHoldersController extends BasePassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/return-pass-holder');
        $this->crud->setEntityNameStrings('Returned Pass Holder', 'Returned Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_RETURNED);
        $this->crud->removeButton('delete');
        $this->crud->removeButton('update');
        //column
        $this->crud->addColumn([
            'name' => 'returned_at', // The db column name
            'label' => 'Returned Date', // Table column heading
            'type' => 'date',
            'format' => DATE_FORMAT, // use something else than the base.default_date_format config value
        ]);

        //filter
        $this->crud->addFilter([ // daterange filter
            'type' => 'date_range',
            'name' => 'date_end_range',
            'label'=> 'Pass Holder Expiry Date Range'
        ],
            false,
            function ($value) {
                $dates = json_decode($value);
                $this->crud->addClause('where', 'pass_expiry_date', '>=', $dates->from);
                $this->crud->addClause('where', 'pass_expiry_date', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->addFilter([ // date filter
            'type' => 'date',
            'name' => 'date',
            'label'=> 'Pass Holder Expiry Date Pickup'
        ],
            false,
            function($value) {
                $this->crud->addClause('where', 'pass_expiry_date', $value);
            });

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'applicant_name',
            'label'=> 'Passholder Name'
        ]);

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'nric',
            'label'=> 'Pass Number'
        ]);

        if (backpack_user()->hasAnyRole(config('backpack.cag.roles'))) {
            $companiesName = Company::getAllCompanies()->pluck('name', 'uen')->toArray();
            $this->crud->addFilter([ // dropdown filter
                'name' => 'company_uen',
                'type' => 'dropdown',
                'label'=> 'Company'
            ], $companiesName);
        }
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeButtonFromStack('import_pass_holders', 'top');
        return $content->with('hideCreatePanel', true);
    }
}
