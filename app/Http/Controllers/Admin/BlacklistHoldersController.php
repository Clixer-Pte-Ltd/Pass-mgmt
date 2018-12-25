<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RenewPassHolderRequest as UpdateRequest;
use App\Events\PassHolderRenew;

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

    public function renew($id)
    {
        $content = parent::edit($id);
        return $content;
    }

    public function updateExpiry(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        $entry = $this->crud->update($request->get($this->crud->model->getKeyName()), ['status' => PASS_STATUS_VALID]);
        event(new PassHolderRenew($entry));
        return $redirect_location;
    }

    public function terminate($id)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = PASS_STATUS_TERMINATED;
        $entry->save();
        return redirect()->back();
    }
}
