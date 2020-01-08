<?php

namespace App\Mail;

use App\Services\ImageService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        $imageService = new ImageService();
        array_map('unlink', glob(storage_path('app/public/images/qr') . "/*.*"));
        $url = $imageService->convertBase64ToFile(str_replace('data:image/png;base64,','', $qrCode), 'qr')['url'];
        $emailViewRender = view('emails.account_info',
            [
                'account' => $this->account,
                'qrCode' => $url,
                'showPass' => false
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Account Info');
        return $this->view('emails.account_info', ['qrCode' => $url, 'showPass' => true])
            ->subject('CAG Airport Pass Tracking Portal (APTP) : Your account has been created');
    }
}
