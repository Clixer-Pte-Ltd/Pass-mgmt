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
     * @return CompanyExpiredMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.expired_company',
            [
                'account' => $this->account,
                'company' => $this->company
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Company Expired Mail');
        return $this->view('emails.expired_company');
    }
}
