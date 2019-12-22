<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Services\LogService;
use App\Models\BackpackUser;

class AccountInfo extends Mailable
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
        //
        $this->account = $account;
    }

    /**
     * @return AccountInfo
     * @throws \Throwable
     */
    public function build()
    {
        $qrCode = app('pragmarx.google2fa')->getQRCodeInline(
            config('app.name'),
            $this->account->email,
            $this->account->google2fa_secret
        );
        $emailViewRender = view('emails.account_info',
            [
                'account' => $this->account,
                'qrCode' => $qrCode,
                'showPass' => false
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Account Info');
        return $this->view('emails.account_info', ['qrCode' => $qrCode, 'showPass' => true])
            ->subject('CAG Airport Pass Tracking Portal (APTP) : Your account has been created');
    }
}
