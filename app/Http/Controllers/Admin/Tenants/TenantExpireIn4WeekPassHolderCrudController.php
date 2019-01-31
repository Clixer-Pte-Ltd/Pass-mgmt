<?php
namespace App\Http\Controllers\Admin\Tenants;

use Carbon\Carbon;

class TenantExpireIn4WeekPassHolderCrudController extends BaseTenantPassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tenant-expire-pass-holder');
        $this->crud->setEntityNameStrings('Teant Expire in 4 weeks Pass Holder', 'Tenant Expire in 4 weeks Pass Holder');
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
            'name' => 'date_end_pickup',
            'label'=> 'Pass Holder Expiry Date Pickup'
        ],
            false,
            function($value) {
                $this->crud->addClause('where', 'pass_expiry_date', $value);
            });
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        return $content->with('hideCreatePanel', true);
    }
}