<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Events\PassHolderRenewed;
use App\Events\PassHolderTerminated;
use App\Http\Requests\RenewPassHolderRequest as UpdateRequest;

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
        $this->crud->addColumn([
            'name' => 'blacklist_reason',
            'label' => 'Blacklist Reason'
        ]);
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
        return $content->with('hideCreatePanel', true);
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
        event(new PassHolderRenewed($entry));
        return $redirect_location;
    }

    public function terminate($id, Request $request)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = PASS_STATUS_TERMINATED;
        $entry->terminate_reason = $request->get('terminate_reason');
        $entry->save();
        event(new PassHolderTerminated($entry));
        \Alert::warning('Terminate successful.')->flash();
        return redirect()->back();
    }
}
