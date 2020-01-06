<?php

use Carbon\Carbon;
// composer require laracasts/testdummy
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Laracasts\TestDummy\Factory as TestDummy;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('settings')->truncate();
        $data = [
            ['key' => SMTP_HOST, 'value' => 'smtp.mailtrap.io', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => SMTP_PORT, 'value' => '2525', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => SMTP_USERNAME, 'value' => 'fff7ae77763fc6', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => SMTP_PASSWORD, 'value' => 'bce275caa272a8', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => SMTP_ENCRYPTION, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => ALLOW_RUN_JOB, 'value' => '1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        foreach ($data as $item) {
            \DB::table('settings')->insert($item);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
