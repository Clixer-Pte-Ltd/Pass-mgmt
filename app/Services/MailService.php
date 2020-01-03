<?php
namespace App\Services;

use App\Jobs\ProcessSendMail;
use Illuminate\Support\Collection;
use App\Services\AccountService;
use App\Models\Company;

class MailService
{
	private $mailForm;
	private $accounts;

	public function __construct($mailForm, $accounts)
	{
		$this->mailForm = "App\Mail\\". $mailForm;
		$this->accounts = $accounts;
	}

	//send mail to all admins (Cag + Company)
	public function passHolderNotifyToAllRelatedAdmin($passHolders, $extraData = [])
	{
        if (!($passHolders instanceof Collection)) {
            $passHolders = collect()->push($passHolders);
        }
        $accountService = new AccountService();
        foreach ($passHolders as $passHolder) {
            $accounts = $accountService->getAllAccountRelatedToPassHolder($passHolder);
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

    public function sendMailToAccount($account = null, $content = null)
    {
        if (!is_null($account)) {
            ProcessSendMail::dispatch($account->email, new $this->mailForm($account, $content));
        }
    }

    public function sendMailToMutilAccounts($content = null, $objectContent = null, $extraData = [], $accountsParam = null)
    {
        $accounts = is_null($accountsParam) ? $this->accounts : $accountsParam;
        foreach ($accounts as $account) {
            ProcessSendMail::dispatch($account->email, new $this->mailForm ($objectContent, $account, $extraData, $content));
        }
    }

    public function sendMailListPassHoldersToAdminCompany($passholders)
    {
        $passholders->pluck('company_uen')->unique()->each(function($uen, $key) use ($passholders) {
            $company = Company::where('uen', $uen)->first();
            if ($company) {
                $passHoldersCompany = $passholders->filter(function ($pass, $key) use ($company) {
                    return $pass->company_uen == $company->uen;
                });
                if ($passHoldersCompany) {
                    $this->sendMailToMutilAccounts(null, $passHoldersCompany, null, $company->accounts());
                }
            }
        });
    }
}
