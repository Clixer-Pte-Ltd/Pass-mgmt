<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class CompanyExpireSoonMail extends Mailable
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
        $dayRest = Carbon::now()
            ->diffInDays(Carbon::parse($this->company->tenancy_end_date));
        app('logService')->logAction($this->account, null, $this->company->toArray(), 'Send Mail Company Expire Soon');
        return $this->view('emails.expire_soon_company', ['dayRest' => $dayRest]);
    }
}
