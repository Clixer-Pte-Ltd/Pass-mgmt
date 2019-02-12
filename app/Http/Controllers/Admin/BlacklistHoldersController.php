<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Events\PassHolderRenewed;
use App\Http\Requests\RenewPassHolderRequest as UpdateRequest;
use App\Events\PassHolderNeedConfirmReturn;

class BlacklistHoldersController extends BasePassHolderCrudController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/blacklist-pass-holder');
        $this->crud->setEntityNameStrings('Blacklist Pass Holder', 'Blacklist Pass Holders');
        $this->crud->addClause('whereIn', 'status', [PASS_STATUS_BLACKLISTED, PASS_STATUS_WAITING_CONFIRM_RETURN]);
        $this->crud->addButtonFromView('line', 'renew', 'renew');
        $this->crud->addButtonFromView('line', 'return', 'return_pass');
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
            'name' => 'date_end_pickup',
            'label'=> 'Pass Holder Expiry Date Pickup'
        ],
            false,
            function($value) {
                $this->crud->addClause('where', 'pass_expiry_date', $value);
            });
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeButtonFromStack('import_pass_holders', 'top');
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

    public function returnPass($id)
    {
        $entry = $this->crud->getEntry($id);
        if (backpack_user()->hasAnyRole([CAG_ADMIN_ROLE, CAG_STAFF_ROLE])) {
            $entry->status = PASS_STATUS_RETURNED;
            $entry->returned_at = Carbon::now();
            $entry->save();
        } else {
            $entry->status = PASS_STATUS_WAITING_CONFIRM_RETURN;
            $entry->save();
            event(new PassHolderNeedConfirmReturn($entry, false));
        }
        \Alert::info('Return done.')->flash();
        return redirect()->back();
    }
}
