<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CompanyExpireSoonMail extends Mailable
{
    use Queueable, SerializesModels;

    public $companies;
    public $account;

    /**
     * Create a new message instance.
     *
     * @param $account
     * @param $companies
     */
    public function __construct($account, $companies)
    {
        $this->companies = $companies;
        $this->account = $account;
    }

    /**
     * @return CompanyExpireSoonMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.expire_soon_company',
            [
                'companies' => $this->companies,
                'account' => $this->account,
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Company Expire Soon');
        return $this->view('emails.expire_soon_company')
            ->subject('CAG Airport Pass Tracking Portal (APTP) : Tenancy contract expiring in 4 weeks\' time');
    }
}
