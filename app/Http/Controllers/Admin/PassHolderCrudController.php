<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// VALIDATION: change the requests to match your own file names if you need form validation
use Maatwebsite\Excel\Excel;
use App\Imports\PassHoldersImport;

/**
 * Class PassHolderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PassHolderCrudController extends BasePassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/pass-holder');
        $this->crud->setEntityNameStrings('Pass Holder', 'Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_VALID);
//        $this->crud->addButtonFromView('line', 'collect', 'collect', 'end');
        $this->addFields();
        $this->addRequired();

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

    public function import(Request $request, Excel $excel)
    {
        if (is_null($request->file('import_file'))) {
            \Alert::error('You must choose file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }

        $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw");
        $result = array($request->file('import_file')->getClientOriginalExtension());

        if (!in_array($result[0],$extensions)) {
            \Alert::error('You must choose excel file')->flash();
            return redirect()->back()->with('not_have_file', 1);
        }
        $excel->import(new PassHoldersImport, $request->file('import_file'));

        \Alert::success('Import successful.')->flash();

        return redirect()->route('crud.pass-holder.index');
    }

    public function importDemo()
    {
        $file = public_path() . '/exports/pass-holders.xlsx';
        return response()->download($file);
    }

    public function blacklist($id, Request $request)
    {
        $entry = $this->crud->getEntry($id);
        $entry->status = PASS_STATUS_BLACKLISTED;
        $entry->blacklist_reason = $request->get('blacklist_reason');
        $entry->save();
        \Alert::info('Blacklist done.')->flash();
        return redirect()->back();
    }
}
