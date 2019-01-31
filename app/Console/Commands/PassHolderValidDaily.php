<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\PassHolderValidDaily as PassHolderValidDailyEvent;
use App\Models\Company;
use Carbon\Carbon;

class PassHolderValidDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:pass_holder:valid_daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send infor valid pass holder to CAG admin + AS/CO của tenant / sub-constructor';

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
        event(new PassHolderValidDailyEvent());
    }
}
