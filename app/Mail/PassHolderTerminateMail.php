<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassHolderTerminateMail extends Mailable
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
     * @return PassHolderTerminateMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.terminate_pass_holder',
            [
                'account' => $this->account,
                'passHolder' => $this->passHolder
            ])->render();

        app('logService')->logAction($this->account, null, $emailViewRender, 'Pass Holder Terminate Mail');
        return $this->view('emails.terminate_pass_holder');
    }
}
