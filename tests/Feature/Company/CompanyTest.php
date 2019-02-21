<?php

namespace Tests\Feature\Company;

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
    }
}
