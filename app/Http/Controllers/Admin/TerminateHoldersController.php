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
        $this->crud->addButtonFromView('line', 'collect', 'collect');
        $this->crud->removeButtonFromStack('update', 'line');
        $this->crud->removeButtonFromStack('delete', 'line');
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeAllButtonsFromStack('top');
        return $content;
    }

    public function collect($id)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = PASS_STATUS_RETURNED;
        $entry->save();
        return redirect()->back();
    }
}
