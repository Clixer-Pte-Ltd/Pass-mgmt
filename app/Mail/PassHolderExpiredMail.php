<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassHolderExpiredMail extends Mailable
{
    use Queueable, SerializesModels;
    public $passHolders;
    public $account;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passHolders, $account)
    {
        $this->passHolders = $passHolders;
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app('logService')->logAction($this->account, null, $this->passHolders, 'Pass Holder Expired Mail');
        return $this->view('emails.expired_pass_holder');
    }
}
