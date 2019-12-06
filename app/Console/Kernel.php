<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Setting;

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
        $schedule->command('cag:tenancy:checking')->daily(); //kiem tra thoi han cua company
        $schedule->command('cag:pass_holder:checking')->cron(getSettingValueByKey(FREQUENCY_EXPIRING_PASS_EMAIL)); //kiem tra thoi han cua pass holder
        $schedule->command('cag:company:update-status ' . COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE)->weeklyOn(1, '00:00:00'); //update status COMPANY_STATUS_WORKING_BUT_NEED_VALIDATE cho company hang tuan
        // $schedule->command('cag:company:validated-checking')->weeklyOn(2, '00:00:00'); //kiem tra validated company
        $schedule->command('cag:revision:checking')->dailyAt('00:00'); //xoa revision qua han
        $schedule->command('cag:pass_holder:checking_confirm_return')->weeklyOn(1, '00:00:00'); //kiem tra confirm return cua admin cag
        $schedule->command('cag:pass_holder:checking_returned_5_year')->dailyAt('00:00'); //xoa pass holder returned 5 nam
        $schedule->command('cag:mail:send_bi_annual_mail')->cron('0 1 * 1,6 *'); //gui email hang ngay
        $schedule->command('cag:pass_holder:valid_daily')->cron(getSettingValueByKey(FREQUENCY_RENEWED_PASS_EMAIL)); // gui list valid pass holder
        $schedule->command('cag:pass_holder:list_pending_return')->cron(getSettingValueByKey(FREQUENCY_TERMINATED_PASS_EMAIL)); // gui list pedding return pass holder
        $schedule->command('cag:user_check_change_password')->daily(); // add notificaion change password
        $schedule->command('cag:adhoc_mail:checking')->dailyAt('00:00'); //xoa adhoc qua han
        $schedule->command('cag:revision:delete')->dailyAt('00:00'); //xoa revision qua han
        $schedule->command('cag:adhoc_mail:delete')->dailyAt('00:00'); //xoa adhoc qua han
        $schedule->command('cag:pass_holder:valid_daily_count')->dailyAt('00:00'); //xoa adhoc qua han
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
