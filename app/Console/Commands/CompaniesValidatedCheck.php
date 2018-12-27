<?php

namespace App\Console\Commands;

use App\Events\CompanyWasNotValidate;
use App\Models\Company;
use Illuminate\Console\Command;

class CompaniesValidatedCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:company:validated-checking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check validated company';

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
        $companies = Company::getAllCompanies()->filter(function($company, $key) {
            return $company->status == COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE;
        });
        event(new CompanyWasNotValidate($companies));
    }
}
