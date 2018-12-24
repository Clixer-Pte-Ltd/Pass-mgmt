<?php

namespace App\Http\Controllers\Admin\Tenants;

use App\Http\Controllers\Admin\BasePassHolderCrudController;

// VALIDATION: change the requests to match your own file names if you need form validation

/**
 * Class PassHolderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BaseTenantPassHolderCrudController extends BasePassHolderCrudController
{
    public function setup()
    {
        parent::setup();
        $this->crud->addClause('whereCompanyUen', backpack_user()->tenant->uen);
    }
}
