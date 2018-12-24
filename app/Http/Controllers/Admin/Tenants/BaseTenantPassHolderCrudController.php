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
        $uen = backpack_user()->tenant ? backpack_user()->tenant->uen : backpack_user()->subConstructor->uen;
        $this->crud->addClause('whereCompanyUen', $uen);
    }
}
