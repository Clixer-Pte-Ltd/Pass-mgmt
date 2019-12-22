<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BiAnnualMail extends Mailable
{
    use Queueable, SerializesModels;

    public $account;
    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $account)
    {
        $this->account = $account;
        $this->company = $company;
    }

    /**
     * @return BiAnnualMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.bi_annual_mail',
            [
                'account' => $this->account,
                'company' => $this->company
            ])->render();

        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Bi Annual Mail');
        return $this->view('emails.bi_annual_mail')
            ->subject('CAG Airport Pass Tracking Portal (APTP) : Announcement');
    }
}
