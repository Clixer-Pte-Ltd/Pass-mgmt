<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class DeleteRevisionExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:revision:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete revision expired';

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
        Activity::where('status', ARCHIVE_ACTIVITY_LOG)->where('updated_at','<', Carbon::now()->subYears(5))->delete();
    }
}
