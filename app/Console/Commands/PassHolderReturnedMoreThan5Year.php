<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PassHolder;
use Carbon\Carbon;

class PassHolderReturnedMoreThan5Year extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:pass_holder:checking_returned_5_year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pass holder more than 5 years delete data.';

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
        PassHolder::where('status', PASS_STATUS_RETURNED)->where('returned_at', '<', Carbon::now()->subYear(5))->delete();
    }
}
