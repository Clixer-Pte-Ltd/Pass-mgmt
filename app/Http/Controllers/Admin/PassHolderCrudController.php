<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
// VALIDATION: change the requests to match your own file names if you need form validation
use Maatwebsite\Excel\Excel;
use App\Imports\PassHoldersImport;
use App\Models\Company;

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
        $this->crud->setEntityNameStrings('Valid Pass Holder', 'Valid Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_VALID);
        $this->crud->addButtonFromView('line', 'blacklist', 'blacklist', 'end');
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
            'name' => 'date',
            'label'=> 'Pass Holder Expiry Date Pickup'
        ],
            false,
            function($value) {
                $this->crud->addClause('where', 'pass_expiry_date', $value);
        });

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'applicant_name',
            'label'=> 'Passholder Name'
        ]);

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'nric',
            'label'=> 'Pass Number'
        ]);

        if (backpack_user()->hasAnyRole(config('backpack.cag.roles'))) {
            $companiesName = Company::getAllCompanies()->pluck('name', 'uen')->toArray();
            $this->crud->addFilter([ // dropdown filter
                'name' => 'company_uen',
                'type' => 'dropdown',
                'label'=> 'Company'
            ], $companiesName);
        }
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
//        $excel->import(new PassHoldersImport, $request->file('import_file'));

        $import = new PassHoldersImport();
        $import->import($request->file('import_file'));
        if ($import->failures()->count() || count($import->error)) {
            return view('errors.error_import', ['failures' => $import->failures(), 'errors' => $import->error]);
        }

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
        \Alert::info('De-List done.')->flash();
        return redirect()->back();
    }

}
