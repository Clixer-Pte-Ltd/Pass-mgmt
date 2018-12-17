<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ZonesTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('zones')->truncate();
        $data = [
            ['name' => 'A1'],
            ['name' => 'A2'],
            ['name' => 'B'],
            ['name' => 'C'],
            ['name' => 'D'],
        ];
        foreach ($data as $item) {
            \DB::table('zones')->insert($item);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
