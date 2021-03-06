<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassHolderValidDailyMail extends Mailable
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
     * @return PassHolderValidDailyMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.valid_pass_holders_daily',
            [
                'account' => $this->account,
                'passHolders' => $this->passHolders
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Pass Holder Valid Daily Mail');
        return $this->markdown('emails.valid_pass_holders_daily');
    }
}
