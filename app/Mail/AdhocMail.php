<?php

namespace App\Mail;

use App\Models\BackpackUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdhocMail extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $subject;
    public $content;
    public $account;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company, $account, $content)
    {
        $this->company = $company;
        $this->content = $content;
        $this->account = $account;
    }

    /**
     * @return AdhocMail
     * @throws \Throwable
     */
    public function build()
    {
        $emailViewRender = view('emails.adhoc',
            [
                'account' => $this->account,
                'content' => $this->content,
                'company' => $this->company
            ])->render();
        app('logService')->logAction($this->account, null, $emailViewRender, 'Send Mail Adhoc Mail');
        return $this->subject(@$this->content->subject)->view('emails.adhoc');
    }
}
