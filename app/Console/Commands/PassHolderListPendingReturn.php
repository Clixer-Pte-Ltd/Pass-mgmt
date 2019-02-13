<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PassHolder;
use App\Events\PassHolderListPendingReturn as PassHolderListPendingReturnEvent;

class PassHolderListPendingReturn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:pass_holder:list_pending_return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List pending return pass holder';

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
        $passHolders = PassHolder::where('status', PASS_STATUS_WAITING_CONFIRM_RETURN)->get();
        event(new PassHolderListPendingReturnEvent($passHolders));
    }
}
