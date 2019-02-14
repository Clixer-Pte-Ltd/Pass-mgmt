<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RemindChangePasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('notifications')->truncate();
        $data = [['name' => 'change password', 'content' => 'Please change password',
                'start_notify_at' => Carbon::now(), 'end_notify_at' => Carbon::now(),
                'type' => NOTIFICATION_SYSTEM, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
                ],
        ];
        foreach ($data as $item) {
            \DB::table('notifications')->insert($item);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
