<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdhocEmail;
use Carbon\Carbon;

class AdhocMailExpireChecking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:adhoc_mail:checking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking adhoc mail expiry';

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
        $adhocMailRetentationRateMonths = getSettingValueByKey(ADHOC_EMAIL_RETENTATION_RATE);
        AdhocEmail::where('created_at','<', Carbon::now()->subMonths($adhocMailRetentationRateMonths))->update(['status' => ARCHIVE_ADHOC_EMAIL]);
    }
}
