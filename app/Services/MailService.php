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

	public function passHolderNotify($passHolders, $extraData = [])
	{
        if (!($passHolders instanceof Collection)) {
            $passHolders = collect()->push($passHolders);
        }
        $accountService = new AccountService();
        foreach ($passHolders as $passHolder) {
            $accounts = $accountService->getAccountRelatedToPassHolder($passHolder);
            $accounts->map(function($account, $index) use ($passHolder, $extraData) {
                ProcessSendMail::dispatch($account->email, new $this->mailForm($passHolder, $account, $extraData));
            });
        }
	}

	public function companiesNotify($companies, $content = null)
    {
        if (!($companies instanceof Collection)) {
            $companies = collect()->push($companies);
        }
        foreach ($companies as $company)
        {
            $this->accounts->map(function($account, $index) use ($company, $content){
                if ($company->hasAccount($account) || !$account->hasCompany())
                {
                    ProcessSendMail::dispatch($account->email, new $this->mailForm($company, $account, $content));
                }
            });
        }
    }

    public function accountNotify($account = null, $content = null)
    {
        if (!is_null($account)) {
            ProcessSendMail::dispatch($account->email, new $this->mailForm($account, $content));
        }
    }
}