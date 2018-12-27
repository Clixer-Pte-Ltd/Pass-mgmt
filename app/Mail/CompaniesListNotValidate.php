<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompaniesListNotValidate extends Mailable
{
    use Queueable, SerializesModels;

    public $companies;
    public $account;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($companies, $account)
    {
        $this->companies = $companies;
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.not_validate_companies');
    }
}
