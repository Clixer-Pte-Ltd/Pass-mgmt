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
            Notification::create(['name' => CHANGE_PASSWORD_NOTIFICATION, 'content' => 'Please change password',
                'start_nofify_at' => Carbon::now(), 'end_notify_at' => Carbon::now()->addDay(),
                'type' => NOTIFICATION_SYSTEM, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
            ]);
            $changePasswordNo = Notification::getByName(CHANGE_PASSWORD_NOTIFICATION);
        }
        BackpackUser::all()->each(function($user, $index) use ($changePasswordNo) {
            if (! $user->notifications->contains($changePasswordNo)) {
                $user->notifications()->attach($changePasswordNo->id);
            }
        });
    }
}
