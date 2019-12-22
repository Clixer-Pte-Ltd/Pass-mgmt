<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $companies;
    public $account;

    /**
     * Create a new message instance.
     *
     * @param $companies
     * @param $account
     */
    public function __construct($account, $companies)
    {
        $this->companies = $companies;
        $this->account = $account;
    }

    /**
     * @return CompanyExpiredMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.expired_company',
            [
                'account' => $this->account,
                'companies' => $this->companies
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Company Expired Mail');
        return $this->view('emails.expired_company')->subject('CAG Airport Pass Tracking Portal (APTP) : Tenancy contract expired');
    }
}
