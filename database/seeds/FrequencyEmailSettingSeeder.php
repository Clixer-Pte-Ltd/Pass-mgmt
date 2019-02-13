<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FrequencyEmailSettingSeeder extends Seeder
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
        $data = [
            ['key' => FREQUENCY_EXPIRING_PASS_EMAIL, 'value' => '0 0 * * *', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => FREQUENCY_BLACKLISTED_PASS_EMAIL, 'value' => '0 0 * * *', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => FREQUENCY_RENEWED_PASS_EMAIL, 'value' => '0 0 * * *', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => FREQUENCY_TERMINATED_PASS_EMAIL, 'value' => '0 0 * * *', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        foreach ($data as $item) {
            \DB::table('settings')->insert($item);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
