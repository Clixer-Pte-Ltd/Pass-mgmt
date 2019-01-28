<?php

use Carbon\Carbon;
// composer require laracasts/testdummy
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Laracasts\TestDummy\Factory as TestDummy;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('roles')->truncate();
        $data = [
            ['name' => 'cag admin', 'guard_name' => 'backpack', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'cag staff', 'guard_name' => 'backpack', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'cag viewer', 'guard_name' => 'backpack', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'company coordinator', 'guard_name' => 'backpack', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'company as', 'guard_name' => 'backpack', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'company viewer', 'guard_name' => 'backpack', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        foreach ($data as $item) {
            \DB::table('roles')->insert($item);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}