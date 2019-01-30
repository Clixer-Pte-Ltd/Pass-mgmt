<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cag:tenancy:checking')->daily();
        $schedule->command('cag:pass_holder:checking')->daily();
        $schedule->command('cag:company:update-status ' . COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE)->weeklyOn(1, '00:00:00');
        $schedule->command('cag:company:validated-checking')->weeklyOn(2, '00:00:00');
        $schedule->command('cag:revision:checking')->dailyAt('00:00');
        $schedule->command('cag:pass_holder:checking_confirm_return')->weeklyOn(1, '00:00:00');
        $schedule->command('cag:pass_holder:checking_returned_5_year')->dailyAt('00:00');
        $schedule->command('cag:mail:send_bi_annual_mail')->cron('0 1 * 1,6 *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
