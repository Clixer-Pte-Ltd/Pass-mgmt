<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class PassHolderExpireSoonMail extends Mailable
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
     * @return PassHolderExpireSoonMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.expire_soon_pass_holder',
            [
                'account' => $this->account,
                'passHolders' => $this->passHolders
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Pass Holder Expire Soon Mail');
        return $this->view('emails.expire_soon_pass_holder')
            ->subject('CAG Airport Pass Tracking Portal (APTP) : Pass/Passes Expiring in 4 weeks\' time');
    }
}
