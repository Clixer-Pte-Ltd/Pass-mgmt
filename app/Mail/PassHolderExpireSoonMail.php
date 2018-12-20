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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dayRest = Carbon::now()
                    ->diffInDays(Carbon::parse($this->passHolder->pass_expiry_date));
        return $this->view('emails.expire_soon_pass_holder', ['dayRest' => $dayRest]);
    }
}
