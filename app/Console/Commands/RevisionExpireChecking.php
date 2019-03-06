<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class RevisionExpireChecking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:revision:checking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking revision expiry';

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
        $revisionRetentationRateMonths = getSettingValueByKey(REVISION_RETENTATION_RATE);
        Activity::where('created_at','<', Carbon::now()->subMonths($revisionRetentationRateMonths))->update(['status' => ARCHIVE_ACTIVITY_LOG]);
    }
}
