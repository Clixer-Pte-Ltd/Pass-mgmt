<?php

namespace App\Http\Controllers\Admin;

class BlacklistHoldersController extends BasePassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blacklist-pass-holder');
        $this->crud->setEntityNameStrings('Blacklist Pass Holder', 'Blacklist Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_BLACKLISTED);
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        $this->crud->removeAllButtonsFromStack('line');
        return $content;
    }
}
