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
        $company = backpack_user()->tenant ?? backpack_user()->subConstructor ?? null;
        if (is_null($company)) {
            return abort(404);
        }
        $this->crud->addClause('whereCompanyUen', $company->uen);
    }
}
