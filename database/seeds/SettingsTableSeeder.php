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
            ['key' => 'smtp_host', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'smtp_port', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'smtp_username', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'smtp_password', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => 'smtp_encryption', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        foreach ($data as $item) {
            \DB::table('settings')->insert($item);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
