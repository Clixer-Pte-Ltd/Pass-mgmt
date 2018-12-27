<?php

namespace App\Console\Commands;

use App\Events\CompanyNeedValidate;
use App\Models\Company;
use Illuminate\Console\Command;

class UpdateStatusCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:company:update-status {status=-1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status company';

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
        $status = $this->argument('status');
        if ($status !== -1) {
            $companies = Company::getAllCompanies();
            if ($status == COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE){
                $companies->map(function($company, $index) {
                    $company->update(['status' => COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE]);
                });
                event(new CompanyNeedValidate($companies));
            }
        }
    }
}
