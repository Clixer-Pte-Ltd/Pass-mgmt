<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AllowSendMailSeeder extends Seeder
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
        foreach (ALLOW_MAIL as $key => $value) {
            \DB::table('settings')->insert([
                'key' => $value,
                'value' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
