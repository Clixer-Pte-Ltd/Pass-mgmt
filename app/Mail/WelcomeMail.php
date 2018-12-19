<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tenant;
use App\Models\SubContructor;

class WelcomeMail extends Mailable
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
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $company = null;
        if (isset($this->account->tenant_id)) {
            $company = Tenant::findOrFail($this->account->tenant_id);
        }
        if (isset($this->account->sub_constructor_id)) {
            $company = SubContructor::findOrFail($this->account->sub_constructor_id);
        }
        return $this->view('emails.new_account_welcome',['company' => $company]);
    }
}
