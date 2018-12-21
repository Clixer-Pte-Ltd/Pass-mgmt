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
        $this->crud->addButtonFromView('line', 'terminate', 'terminate');
        $this->crud->addButtonFromView('line', 'renew', 'renew');
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        return $content;
    }

    public function renew($id)
    {
        $entry = $this->crud->getEntry($id);
    }

    public function terminate($id)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = PASS_STATUS_TERMINATED;
        $entry->save();
        return redirect()->back();
    }
}
