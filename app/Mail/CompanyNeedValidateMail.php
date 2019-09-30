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
     * @return CompanyNeedValidateMail
     * @throws \Throwable
     */
    public function build()
    {
        $link = ($this->company instanceof Tenant) ?
            route('admin.tenant.validate-company',['id' => $this->company->id]) :
            route('admin.sub-constructor.validate-company', ['id' => $this->company->id]);
        $emailViewRender = view('emails.validate_company',
            [
                'account' => $this->account,
                'company' => $this->company,
                'link' => $link
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Company Need Validate Mail');
        return $this->view('emails.validate_company', ['link' => $link]);
    }
}
