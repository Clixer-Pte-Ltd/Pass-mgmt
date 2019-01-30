<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PassHolder;
use App\Events\PassHolderNeedConfirmReturn;

class PassHolderCheckConfirmReturn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:pass_holder:checking_confirm_return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pass holder checking need confirm return';

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
        $passHoldersCount = PassHolder::where('status', PASS_STATUS_WAITING_CONFIRM_RETURN)->count();
        if ($passHoldersCount) {
            event(new PassHolderNeedConfirmReturn(null, true));
        }
    }
}
