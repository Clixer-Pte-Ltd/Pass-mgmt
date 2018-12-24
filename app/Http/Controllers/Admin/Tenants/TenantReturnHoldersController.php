<?php

namespace App\Http\Controllers\Admin\Tenants;

class TenantReturnHoldersController extends BaseTenantPassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tenant-return-pass-holder');
        $this->crud->setEntityNameStrings('Returned Pass Holder', 'Returned Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_RETURNED);
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->removeAllButtonsFromStack('line');
        return $content;
    }
}
