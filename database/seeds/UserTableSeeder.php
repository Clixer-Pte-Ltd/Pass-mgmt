<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
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

        \DB::table('users')->truncate();
        \DB::table('model_has_roles')->truncate();
        $data = [
            [
                'data' => ['id' => 1, 'name' => 'Manager (A) Aviation Security', 'email' => 'Ong.Jun.Xiang@changiairport.com', 'password' => DEFAULT_PASSWORD, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                'role' => ['role_id' => CAG_ADMIN_ROLE_ID, 'model_type' => 'App\Models\BackpackUser', 'model_id' => 1]
            ],
            [
                'data' => ['id' => 2, 'name' => 'Manager (B) Aviation Security', 'email' => 'zainal.abidin.hussain@changiairport.com', 'password' => DEFAULT_PASSWORD, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                'role' => ['role_id' => CAG_ADMIN_ROLE_ID, 'model_type' => 'App\Models\BackpackUser', 'model_id' => 2]
            ],
            [
                'data' => ['id' => 3, 'name' => 'OC Airport Pass Office', 'email' => 'daveLF_Wong@certisgroup.com', 'password' => DEFAULT_PASSWORD, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                'role' => ['role_id' => CAG_ADMIN_ROLE_ID, 'model_type' => 'App\Models\BackpackUser', 'model_id' => 3]
            ],
            [
                'data' => ['id' => 4, 'name' => 'Deputy OC Pass Office', 'email' => 'magesvarry_ponnusamy@certissecurity.com', 'password' => DEFAULT_PASSWORD, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                'role' => ['role_id' => CAG_STAFF_ROLE_ID, 'model_type' => 'App\Models\BackpackUser', 'model_id' => 4]
            ],
            [
                'data' => ['id' => 5, 'name' => 'Airport Pass Office Portal Admin', 'email' => 'test5@gmail.com', 'password' => DEFAULT_PASSWORD, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                'role' => ['role_id' => CAG_STAFF_ROLE_ID, 'model_type' => 'App\Models\BackpackUser', 'model_id' => 5]
            ]
        ];
        foreach ($data as $item) {
            \DB::table('users')->insert($item['data']);
            \DB::table('model_has_roles')->insert($item['role']);
        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
