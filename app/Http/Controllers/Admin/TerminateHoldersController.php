<?php

namespace App\Http\Controllers\Admin;

class TerminateHoldersController extends BasePassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/terminate-pass-holder');
        $this->crud->setEntityNameStrings('Terminated Pass Holder', 'Terminated Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_TERMINATED);
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->removeAllButtonsFromStack('line');
        return $content;
    }
}
