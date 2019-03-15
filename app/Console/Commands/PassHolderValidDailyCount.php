<?php

namespace App\Console\Commands;

use App\Models\PassHolder;
use Illuminate\Console\Command;

class PassHolderValidDailyCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:pass_holder:valid_daily_count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count valid pass holder';

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
        $num = PassHolder::where('status', PASS_STATUS_VALID)->count();
        app('logService')->logAction(null, null, ['count' => $num], 'Pass Holder Valid Daily Count');
    }
}
