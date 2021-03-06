<?php

namespace App\Jobs;

use App\Mail\AccountInfo;
use App\Mail\WelcomeMail;
use App\Models\BackpackUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class ProcessSendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 10;
    private $mailSend;
    private $mailForm;
    public $server;

    /**
     * Create a new job instance.
     *
     * @param $mailSend
     * @param $mailForm
     */
    public function __construct($mailSend, $mailForm)
    {
        $this->mailSend = $mailSend;
        $this->mailForm = $mailForm;
        $this->server = config('app.server_type');
    }

    /**
     * Execute the job.
     *
     * @return bool
     * @throws \Exception
     */
    public function handle()
    {
        if ($this->server == config('app.server_type')) {
            $logSenMail = null;
            try {
                $setting = getSettingMail(get_class($this->mailForm));
                if (getSettingValueByKey($setting)) {
                    sleep(3);
                    Mail::to($this->mailSend)->send($this->mailForm);
                }
            } catch (\Exception $e) {
                $logSenMail = $e->getMessage();
                logger([$e->getLine() => $e->getMessage()]);
            }
            $user = BackpackUser::where('email', $this->mailSend)->first();
            if ($user && $this->mailForm instanceof AccountInfo && getSettingValueByKey(ALLOW_MAIL['APP_MAIL_ACCOUNTINFO'])) {
                $user->update([
                    'send_info_email_log' => $logSenMail
                ]);
            }
        }
    }
}
