<?php

namespace App\Http\Controllers\Admin\Tenants;

class TenantTerminateHoldersController extends BaseTenantPassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tenant-terminate-pass-holder');
        $this->crud->setEntityNameStrings('Terminated Pass Holder', 'Terminated Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_TERMINATED);
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        return $content;
    }
}
