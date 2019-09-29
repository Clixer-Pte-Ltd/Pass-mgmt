<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PassHolderRenewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $passHolder;
    public $account;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passHolder, $account)
    {
        $this->passHolder = $passHolder;
        $this->account = $account;
    }

    /**
     * @return PassHolderRenewMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.renew_pass_holder',
            [
                'account' => $this->account,
                'passHolder' => $this->passHolder
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Pass Holder Renew Mail');
        return $this->view('emails.renew_pass_holder');
    }
}
