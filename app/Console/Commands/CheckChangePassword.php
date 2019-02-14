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
        $changePasswordNo = Notification::getByName(CHANGE_PASSWORD_NOTIFICATION);
        if ($changePasswordNo) {
            BackpackUser::all()->each(function($user, $index) use ($changePasswordNo) {
                if (! $user->notifications->contains($changePasswordNo) && $user->last_modify_password_at->lt(Carbon::now()->subMonths(3))) {
                    $user->notifications()->attach($changePasswordNo->id);
                }
            });
        }
    }
}
