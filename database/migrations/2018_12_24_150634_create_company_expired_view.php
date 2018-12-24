<?php

use Illuminate\Database\Migrations\Migration;

class CreateCompanyExpiredView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('
            CREATE VIEW expired_companies
            AS
            SELECT tenants.uen, "App\\\\Models\\\\\Tenant" as type, tenants.name, tenants.tenancy_start_date, tenants.tenancy_end_date FROM tenants WHERE tenants.status = 2
            UNION
            SELECT sub_constructors.uen, "App\\\\Models\\\\SubConstructor" as type , sub_constructors.name, sub_constructors.tenancy_start_date, sub_constructors.tenancy_end_date FROM sub_constructors WHERE sub_constructors.status = 2;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS expired_companies');
    }
}
