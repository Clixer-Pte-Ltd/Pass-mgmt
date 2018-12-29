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
        $this->crud->addClause('whereStatus', PASS_STATUS_BLACKLISTED);
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
        $this->crud->setEditView('crud::pass-holders.renew');
        $this->crud->addField([
            'name' => 'pass_expiry_date',
            'type' => 'date_picker',
            'label' => 'Pass Expiry Date'
        ]);
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        return $content;
    }
}