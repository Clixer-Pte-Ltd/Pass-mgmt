<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyNotifyNewAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $account;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($account)
    {
        $this->account = $account;
    }

    /**
     * @return CompanyNotifyNewAccount
     * @throws \Throwable
     */
    public function build()
    {
        $link = route('backpack.auth.show.verify.question',['token' => urlencode($this->account->token)]);
        $company = $this->account->getCompany();
        $companyName = '';
        if ($company) {
            $companyName = $company->pluck('name')->implode(',');
        }
        $emailViewRender = view('emails.create_user_account',
            [
                'account' => $this->account,
                'link' => $link,
                'companyName' => $companyName
            ])->render();

        app('logService')->logAction($this->account, null, $emailViewRender, 'Company Notify New Account');
        return $this->view('emails.create_user_account', ['link' => $link, 'companyName' => $companyName]);
    }
}
