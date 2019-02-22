<?php

namespace Tests\Feature\Company;

use App\Imports\TenantsImport;
use App\Models\Company;
use App\Models\Tenant;
use Maatwebsite\Excel\Excel;
use Tests\Feature\CrudTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyTest extends CrudTest
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRenew($model)
    {
        $this->testlogin();
        $model->update(['status' => COMPANY_STATUS_EXPIRED]);
        $route = route('admin.company.renew', $model->uen);
        $dateRenew = Carbon::now()->addDay()->format('Y-m-d');
        $this->get($route)->assertStatus(200);
        $this->from($route)->post(route('admin.company.updateExpiry', [$model->uen]), [
            'tenancy_end_date' => $dateRenew,
            'uen' => $model->uen,
        ])->assertStatus(302);
        $renewModel = DB::table($this->table)->where('uen', $model->uen)->first();
        $this->assertEquals($renewModel->tenancy_end_date, $dateRenew);
        $this->assertEquals($renewModel->status, COMPANY_STATUS_WORKING);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testImportAccounts($filename)
    {
        $this->testlogin();
        $file = $this->prepareFile($filename);
        $this->get('/admin/' . $this->baseUri)->assertStatus(200);
        $this->from('/admin/' . $this->baseUri)->post('/admin/' .  $this->baseUri . '/account/import', [
            'import_file' => $file
        ])->assertStatus(302);
        foreach ($this->dataCheck as $data) {
            unset($data['company_uen']);
            $this->assertDatabaseHas('users', $data);
        }
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    protected function importCompany($filename, $classModelName, $classImportName)
    {
        $companies =  \Excel::toCollection(new $classImportName, $this->prepareFile($filename))->toArray()[0];
        foreach ($companies as $company) {
            $company['tenancy_start_date'] = convertFormatDate($company['tenancy_start_date'], 'd/m/Y', 'Y-m-d');
            $company['tenancy_end_date'] = convertFormatDate($company['tenancy_end_date'], 'd/m/Y', 'Y-m-d');
            if (isset($company['tenant_uen'])) {
                $tenant = Tenant::where('uen', $company['tenant_uen'])->first();
                if ($tenant) {
                    $company['tenant_id'] = $tenant->id;
                }
                unset($company['tenant_uen']);
            }
            factory($classModelName)->create($company);
        }
    }

}
