<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 09/01/2019
 * Time: 14:52
 */

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Company;

class ExpireIn4WeekPassHolderCrudController extends BasePassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/expire-pass-holder');
        $this->crud->setEntityNameStrings('Expire in 4 weeks Pass Holder', 'Expire in 4 weeks Pass Holder');
        $this->crud->addClause('where', 'pass_expiry_date', '<=', Carbon::now()->addWeeks(4));
        $this->crud->addClause('where', 'pass_expiry_date', '>', Carbon::now());
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');

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
            'label'=> 'Applicant Name'
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
