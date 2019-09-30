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
     * @return CompanyExpireSoonMail
     * @throws \Throwable
     */
    public function build()
    {
        $dayRest = Carbon::now()
            ->diffInDays(Carbon::parse($this->company->tenancy_end_date));
        $emailViewRender = view('emails.expire_soon_company',
            [
                'company' => $this->company,
                'account' => $this->account,
                'dayRest' => $dayRest
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Company Expire Soon');
        return $this->view('emails.expire_soon_company', ['dayRest' => $dayRest]);
    }
}
