<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Events\PassHolderRenewed;
use App\Http\Requests\RenewPassHolderRequest as UpdateRequest;

class ConfirmPassHoldersController extends BasePassHolderCrudController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('hasRoles:' . implodeCag([CAG_ADMIN_ROLE, CAG_STAFF_ROLE, COMPANY_CO_ROLE, COMPANY_AS_ROLE]))->only(['returnPass']);
    }
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/confirm-return-pass-holder');
        $this->crud->setEntityNameStrings('Pass Holder Need Confirm Return', 'Pass Holder Need Confirm Return');
        $this->crud->addClause('whereStatus', PASS_STATUS_WAITING_CONFIRM_RETURN);
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
        $this->crud->addButtonFromView('line', 'return', 'return_pass');

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
