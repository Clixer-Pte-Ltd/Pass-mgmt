<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\BackpackUser;

class CheckChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cag:user_check_change_password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update notification change password for user';

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
        BackpackUser::where('last_modify_password_at', '<=', Carbon::now()->subMonths(9))->update(['change_first_pass_done' => 0]);
    }
}
