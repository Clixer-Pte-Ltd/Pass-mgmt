<?php
use Carbon\Carbon;
// composer require laracasts/testdummy
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RevisionSettingSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $data = [
            ['key' => REVISION_UPDATED, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => REVISION_DELETED, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => REVISION_CREATED, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['key' => REVISION_RETENTATION_RATE, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        foreach ($data as $item) {
            \DB::table('settings')->insert($item);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}