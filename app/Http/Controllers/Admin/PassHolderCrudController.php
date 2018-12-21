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
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->addButtonFromView('top', 'import_pass_holders', 'import_pass_holders', 'end');
        return $content;
    }

    public function import(Request $request, Excel $excel)
    {
        $excel->import(new PassHoldersImport, $request->file('import_file'));

        \Alert::success('Import successful.')->flash();

        return redirect()->route('crud.pass-holder.index');
    }

    public function importDemo()
    {
        $file = public_path() . '/exports/pass-holders.xlsx';
        return response()->download($file);
    }
}
