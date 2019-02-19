<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyExpiredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $account;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $account)
    {
        $this->company = $company;
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app('logService')->logAction($this->account, null, $this->company->toArray(), 'Send Mail Company Expired Mail');
        return $this->view('emails.expired_company');
    }
}
