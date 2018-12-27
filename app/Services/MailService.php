<?php
namespace App\Services;

use App\Jobs\ProcessSendMail;
use Illuminate\Support\Collection;
use App\Services\AccountService;

class MailService
{
	private $mailForm;
	private $accounts;

	public function __construct($mailForm, $accounts)
	{
		$this->mailForm = "App\Mail\\". $mailForm;
		$this->accounts = $accounts;
	}

	public function passHolderNotify($passHolders)
	{
        if (!($passHolders instanceof Collection)) {
            $passHolders = collect()->push($passHolders);
        }
        $accountService = new AccountService();
        foreach ($passHolders as $passHolder) {
            $accounts = $accountService->getAccountRelatedToPassHolder($passHolder);
            $accounts->map(function($account, $index) use ($passHolder) {
                ProcessSendMail::dispatch($account->email, new $this->mailForm($passHolder, $account));
            });
        }
	}

	public function companiesNotify($companies)
    {
        if (!($companies instanceof Collection)) {
            $companies = collect()->push($companies);
        }
        foreach ($companies as $company)
        {
            $this->accounts->map(function($account, $index) use ($company){
                if ($company->hasAccount($account) || !$account->hasCompany())
                {
                    ProcessSendMail::dispatch($account->email, new $this->mailForm($company, $account));
                }
            });
        }
    }

}