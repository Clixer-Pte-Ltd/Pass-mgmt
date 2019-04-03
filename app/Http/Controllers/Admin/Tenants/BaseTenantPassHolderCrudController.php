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
        if (backpack_user()->hasRole(COMPANY_AS_ROLE)) {
            $company = backpack_user()->tenantsOfAs->pluck('uen')->toArray();
            $this->crud->addClause('whereIn', 'company_uen', $company);
        } else {
            $company = backpack_user()->getCompany();
            $this->crud->addClause('whereInCompanyUen', $company->uen);
        }
        if (is_null($company)) {
            return abort(404);
        }
    }
}
