<?php

namespace App\Http\Controllers\Admin\Tenants;

use App\Http\Controllers\Admin\BasePassHolderCrudController;
use Illuminate\Support\Collection;

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
        $company = backpack_user()->getCompany();
        if ($company instanceof Collection) {
            $this->crud->addClause('whereIn', 'company_uen', $company->pluck('uen')->toArray());
        } else {
            $this->crud->addClause('where', 'company_uen', $company->uen);
        }
        if (is_null($company)) {
            return abort(404);
        }
    }
}
