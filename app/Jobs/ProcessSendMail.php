<?php

namespace App\Jobs;

use App\Mail\AccountInfo;
use App\Mail\WelcomeMail;
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
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailSend, $mailForm)
    {
        $this->mailSend = $mailSend;
        $this->mailForm = $mailForm;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logSenMail = null;
        try {
            sleep(5);
            if ($this->mailForm instanceof WelcomeMail) {
                Mail::to($this->mailSend)->send($this->mailForm);
            }
        } catch (\Exception $e) {
//            $logSenMail = $e->getMessage();
            logger([$e->getLine() => $e->getMessage()]);
        }
//        if ($this->mailForm instanceof AccountInfo) {
//            $this->mailSend->update([
//                'send_info_email_log' => $logSenMail
//            ]);
//        }
    }
}
