<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdhocEmail;
use Carbon\Carbon;

class DeleteAdhocMailExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:adhoc_mail:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete adhoc mail expired';

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
        AdhocEmail::where('status', ARCHIVE_ADHOC_EMAIL)->where('updated_at','<', Carbon::now()->subYears(5))->delete();
    }
}
