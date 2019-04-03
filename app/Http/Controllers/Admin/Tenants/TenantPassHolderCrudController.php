<?php

namespace App\Http\Controllers\Admin\Tenants;

use Illuminate\Http\Request;
// VALIDATION: change the requests to match your own file names if you need form validation
use Maatwebsite\Excel\Excel;
use App\Imports\TenantPassHoldersImport;
use App\Http\Requests\StorePassHolderRequest as StoreRequest;
use App\Http\Requests\UpdatePassHolderRequest as UpdateRequest;

/**
 * Class PassHolderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TenantPassHolderCrudController extends BaseTenantPassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/tenant-pass-holder');
        $this->crud->setEntityNameStrings('Pass Holder', 'Pass Holders');
        $this->crud->addClause('whereStatus', PASS_STATUS_VALID);
        $this->crud->addButtonFromView('line', 'blacklist', 'blacklist', 'end');
        $this->addFields();
        $this->addRequired();

        $this->crud->removeField('company_uen');

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

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'applicant_name',
            'label'=> 'Applicant Name'
        ]);

        $this->crud->addFilter([ // simple filter
            'type' => 'text',
            'name' => 'nric',
            'label'=> 'Nric'
        ]);

    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeButtonFromStack('import_pass_holders', 'top');
        if (!backpack_user()->hasAnyRole([CAG_VIEWER_ROLE, COMPANY_VIEWER_ROLE])) {
            $this->crud->addButtonFromView('top', 'tenant_import_pass_holders', 'tenant_import_pass_holders', 'end');
        }
        return $content;
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
//        $excel->import(new TenantPassHoldersImport, $request->file('import_file'));
        $import = new TenantPassHoldersImport();
        $import->import($request->file('import_file'));
        if ($import->failures()->count() || count($import->error)) {
            return view('errors.error_import', ['failures' => $import->failures(), 'errors' => $import->error]);
        }
        \Alert::success('Import successful.')->flash();

        return redirect()->route('crud.tenant-pass-holder.index');
    }

    public function importDemo()
    {
        $file = public_path() . '/exports/tenant-pass-holders.xlsx';
        return response()->download($file);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return redirect()->route('crud.tenant-pass-holder.index');
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

}
