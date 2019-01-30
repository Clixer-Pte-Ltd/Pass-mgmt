<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Events\MailWasSentBiAnnual;

class SendBiAnnualEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:mail:send_bi_annual_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Bi-Annual Email (6 months Once), send reminder to all CO/Tenant/Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        event(new MailWasSentBiAnnual());
    }
}
