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
}