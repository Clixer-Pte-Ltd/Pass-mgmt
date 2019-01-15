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
        $this->crud->addColumn([
            'name' => 'terminate_reason',
            'label' => 'Terminate Reason'
        ]);

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
        $this->crud->removeAllButtonsFromStack('top');
        return $content->with('hideCreatePanel', true);
    }

    public function collect($id)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = PASS_STATUS_RETURNED;
        $entry->save();
        return redirect()->back();
    }
}
