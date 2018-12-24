<?php

namespace App\Http\Controllers\Admin\Tenants;

use Illuminate\Http\Request;
// VALIDATION: change the requests to match your own file names if you need form validation
use Maatwebsite\Excel\Excel;
use App\Imports\TenantPassHoldersImport;

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
        $this->addFields();
        $this->addRequired();

        $this->crud->removeField('company_uen');

        $this->crud->addField([
            'label' => 'Company',
            'name' => 'company_uen',
            'type' => 'hidden',
            'value' => backpack_user()->tenant->uen
        ]);
    }

    public function index()
    {
        $content = parent::index();
        $this->crud->removeButtonFromStack('import_pass_holders', 'top');
        $this->crud->addButtonFromView('top', 'tenant_import_pass_holders', 'tenant_import_pass_holders', 'end');
        return $content;
    }

    public function import(Request $request, Excel $excel)
    {
        $excel->import(new TenantPassHoldersImport, $request->file('import_file'));

        \Alert::success('Import successful.')->flash();

        return redirect()->route('crud.tenant-pass-holder.index');
    }

    public function importDemo()
    {
        $file = public_path() . '/exports/tenant-pass-holders.xlsx';
        return response()->download($file);
    }
}
