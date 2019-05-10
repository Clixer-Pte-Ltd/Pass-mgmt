<?php

namespace App\Http\Controllers\Admin\Tenants;

use App\Http\Requests\RenewPassHolderRequest as UpdateRequest;

class TenantBlacklistHoldersController extends BaseTenantPassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tenant-blacklist-pass-holder');
        $this->crud->setEntityNameStrings('Blacklist Pass Holder', 'Blacklist Pass Holders');
        $this->crud->addClause('whereIn', 'status', [PASS_STATUS_BLACKLISTED, PASS_STATUS_WAITING_CONFIRM_RETURN]);
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
        $this->crud->addButtonFromView('line', 'return', 'return_pass');
        if (backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, CAG_STAFF_ROLE])) {
            $this->crud->addButtonFromView('line', 'renew', 'renew');
        }
        $this->crud->setEditView('crud::pass-holders.renew');
        $this->crud->addField([
            'name' => 'pass_expiry_date',
            'type' => 'date_picker',
            'label' => 'Pass Expiry Date'
        ]);
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

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

    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeButtonFromStack('import_pass_holders', 'top');
        return $content;
    }
}
