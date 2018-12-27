<?php

namespace App\Mail;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyNeedValidateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $account;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $account)
    {
        $this->company = $company;
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = ($this->company instanceof Tenant) ?
            route('admin.tenant.validate-company',['id' => $this->company->id]) :
            route('admin.sub-constructor.validate-company', ['id' => $this->company->id]);
        return $this->view('emails.validate_company', ['link' => $link]);
    }
}
