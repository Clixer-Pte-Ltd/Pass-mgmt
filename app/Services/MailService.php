<?php
namespace App\Services;

use App\Jobs\ProcessSendMail;

class MailService
{
	private $mailForm;
	private $accounts;

	public function __construct($mailForm, $accounts)
	{
		$this->mailForm = "App\Mail\\". $mailForm;
		$this->accounts = $accounts;
	}

	public function passHolderNotify($pass_holder)
	{
		$this->accounts->map(function($account, $index) use ($pass_holder) {
            ProcessSendMail::dispatch($account->email, new $this->mailForm($pass_holder, $account));
        });
	}
}