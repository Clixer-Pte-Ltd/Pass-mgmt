<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PassHolderNeedConfirmReturnMail extends Mailable
{
    use Queueable, SerializesModels;

    public $passHolder;
    public $account;
    public $isListPass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passHolder, $account, $extraData)
    {
        $this->passHolder = @$passHolder;
        $this->account = $account;
        foreach ($extraData as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (@$this->isListPass) {
            $link = route('crud.confirm-return-pass-holder.index');
        } else {
            $link = route('crud.pass-holder.show',['id' => urlencode($this->passHolder->id)]);
        }
        return $this->view('emails.confirm_return_pass_holder', ['link' => $link]);
    }
}
