<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Tenant;
use App\Events\CompanyExpired;
use Illuminate\Console\Command;

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

    private function checkingTenants()
    {
        $tenants_query = Tenant::whereIn('status', $this->checkingStatusCondition())
                                    ->where('tenancy_end_date', '<', Carbon::now());
        $tenants = $tenants_query->get();
        $tenants_query->update(['status' => COMPANY_STATUS_EXPIRED]);
        event(new CompanyExpired($tenants));
    }

    public function checkingSubContructors()
    {
        $sub_constructors_query = Tenant::whereIn('status', $this->checkingStatusCondition())
                                            ->where('tenancy_end_date', '<', Carbon::now());
        $sub_constructors = $sub_constructors_query->get();
        $sub_constructors_query->update(['status' => COMPANY_STATUS_EXPIRED]);
        event(new CompanyExpired($sub_constructors));
    }
}
