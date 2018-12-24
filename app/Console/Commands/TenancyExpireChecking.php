<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tenant;
use App\Events\CompanyExpired;
use Illuminate\Console\Command;
use App\Models\SubConstructor;
use App\Events\CompanyExpireSoon;

class TenancyExpireChecking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:tenancy:checking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking tenancy expiry';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkingTenants();
        $this->checkingSubContructors();
    }

    private function checkingStatusCondition()
    {
        return [
            COMPANY_STATUS_WORKING,
            COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE
        ];
    }

    private function checkingCompany($companyType)
    {
        $query = $companyType->whereIn('status', $this->checkingStatusCondition())
                                    ->where('tenancy_end_date', '<', Carbon::now());
        $companies = $query->get();
        $query->update(['status' => COMPANY_STATUS_EXPIRED]);
        event(new CompanyExpired($companies));
    }

    private function checkingTenants()
    {
        $this->checkingCompany(Tenant::query());
        $this->checkCompanyExpireSoon(Tenant::query());
    }

    private function checkingSubContructors()
    {
        $this->checkingCompany(SubConstructor::query());
        $this->checkCompanyExpireSoon(SubConstructor::query());
    }

    private function checkCompanyExpireSoon($companyType)
    {
        $query = $companyType->orWhere(function ($query) {
            $query->where('tenancy_end_date', '<=', Carbon::now()->addWeeks(4))
                ->where('tenancy_end_date', '>', Carbon::now()->addWeeks(4)->subDay());
        })
            ->orWhere(function ($query) {
                $query->where('tenancy_end_date', '<=', Carbon::now()->addWeeks(3))
                    ->where('tenancy_end_date', '>', Carbon::now()->addWeeks(3)->subDay());
            })
            ->orWhere(function ($query) {
                $query->where('tenancy_end_date', '<=', Carbon::now()->addWeeks(2))
                    ->where('tenancy_end_date', '>', Carbon::now()->addWeeks(2)->subDay());
            })
            ->orWhere(function ($query) {
                $query->where('tenancy_end_date', '<=', Carbon::now()->addWeeks(1))
                    ->where('tenancy_end_date', '>', Carbon::now()->addWeeks(1)->subDay());
            });

        $companies = $query->get();
        event(new CompanyExpireSoon($companies));
    }
}
