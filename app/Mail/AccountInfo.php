<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountInfo extends Mailable
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
        //
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.account_info');
    }
}
