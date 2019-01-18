<?php
/**
 * Created by PhpStorm.
 * User: hm
 * Date: 17/01/2019
 * Time: 16:48
 */

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\RenewCompanyRequest as RenewRequest;

class CompanyCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\ExpiredCompany');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/company');
        $this->crud->setEntityNameStrings('Expire Company', 'Expire Company');
        $this->crud->setEditView('crud::companies.renew');
    }

    public function renew($uen)
    {
        $this->crud->addField([
            'name' => 'tenancy_end_date',
            'type' => 'date_picker',
            'label' => 'Tenancy End Date'
        ]);
        $content = parent::edit($uen);
        return $content;
    }

    public function updateExpiry(RenewRequest $request)
    {
        $this->crud->getEntry($request->uen)->companyable->update(['tenancy_end_date' => $request->tenancy_end_date, 'status' => COMPANY_STATUS_WORKING]);
        return redirect()->route('crud.expired-company.index');
    }
}