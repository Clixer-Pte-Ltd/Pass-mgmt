<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tenant;
use App\Models\SubContructor;

class WelcomeMail extends Mailable
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
     * @return WelcomeMail
     * @throws \Throwable
     */
    public function build()
    {
        $company = $this->account->getCompany();
        $companyName = '';
        if ($company) {
            $companyName = $company->pluck('name')->implode(',');
        }
        $emailViewRender = view('emails.new_account_welcome',
            [
                'account' => $this->account,
                'companyName' => $companyName
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'WelcomeMail');
        return $this->view('emails.new_account_welcome', ['companyName' => $companyName]);
    }
}
