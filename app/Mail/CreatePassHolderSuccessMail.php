<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePassHolderSuccessMail extends Mailable
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
     * @return CreatePassHolderSuccessMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.new_pass_holder_created',
            [
                'account' => $this->account,
                'passHolder' => $this->passHolder
            ])->render();

        app('logService')->logAction($this->account, null, $emailViewRender, 'Create Pass Holder Success Mail');
        return $this->view('emails.new_pass_holder_created');
    }
}
