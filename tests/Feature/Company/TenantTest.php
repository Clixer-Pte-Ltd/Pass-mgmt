<?php

namespace Tests\Feature\Company;

use App\Imports\TenantAccountsImport;
use App\Imports\TenantsImport;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Generator as Faker;
use Tests\Feature\CrudTest;
use Carbon\Carbon;
use Tightenco\Parental\Tests\Models\Car;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TenantTest extends CompanyTest
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->table = 'tenants';
        $this->baseUri = 'tenant';
    }

    /**
     * test create
     * @group company_tenant_create
     * @test
     * @return void
     */
    public function create()
    {
        $this->dataCheck = $this->dataCreate = factory(Tenant::class)->make()->toArray();
        $this->dataCheck['tenancy_start_date'] = $this->dataCheck['tenancy_start_date']->format('Y-m-d');
        $this->dataCheck['tenancy_end_date'] = $this->dataCheck['tenancy_end_date']->format('Y-m-d');
        $this->testCreate();
    }

    /**
     * test update
     * @group company_tenant_update
     * @test
     * @return void
     */
    public function update()
    {
        $tenant = factory(Tenant::class)->create();
        $this->dataCheck = $this->dataUpdate = factory(Tenant::class)->make()->toArray();
        $this->dataUpdate['id'] = $tenant->id;
        $this->dataCheck['tenancy_start_date'] = $this->dataCheck['tenancy_start_date']->format('Y-m-d');
        $this->dataCheck['tenancy_end_date'] = $this->dataCheck['tenancy_end_date']->format('Y-m-d');
        $this->testUpdate($tenant);
    }

    /**
     * test update
     * @group company_tenant_show
     * @test
     * @return void
     */
    public function show()
    {
        $tenant = factory(Tenant::class)->create();
        $this->testShow($tenant, 'crud::tenant.show');
    }

    /**
     * test delete
     * @group company_tenant_delete
     * @test
     * @return void
     */
    public function delete()
    {
        $tenant = factory(Tenant::class)->create();
        $this->dataCheck = $tenant->toArray();
        $this->dataCheck['tenancy_start_date'] = $this->dataCheck['tenancy_start_date']->format('Y-m-d');
        $this->dataCheck['tenancy_end_date'] = $this->dataCheck['tenancy_end_date']->format('Y-m-d');
        $this->testDelete($tenant);
    }

    /**
     * test renew
     * @group company_tenant_renew
     * @test
     * @return void
     */
    public function renew()
    {
        $tenant = factory(Tenant::class)->create();
        $this->testRenew($tenant);
    }

    /**
     * test import
     * @group company_tenant_import
     * @test
     * @return void
     */
    public function import()
    {
        $nameFile = 'tenants.xlsx';
        $this->dataCheck = \Excel::toCollection(new TenantsImport, $this->prepareFile($nameFile))->toArray()[0];
        $this->testImport($nameFile);
    }

    /**
     * test import account
     * @group company_tenant_import_accounts
     * @test
     * @return void
     */
    public function importAccounts()
    {
        $this->importCompany('tenants.xlsx', Tenant::class, TenantsImport::class);
        $nameFile = 'tenant_accounts.xlsx';
        $this->dataCheck = \Excel::toCollection(new TenantAccountsImport, $this->prepareFile($nameFile))->toArray()[0];
        $this->testImportAccounts($nameFile);
    }
}
