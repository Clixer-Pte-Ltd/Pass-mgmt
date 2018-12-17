<?php

use Illuminate\Database\Migrations\Migration;

class CreateCompaniesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('
            CREATE VIEW companies
            AS
            SELECT tenants.uen, "App\\\\Models\\\\\Tenant" as type, tenants.name FROM tenants
            UNION
            SELECT sub_constructors.uen, "App\\\\Models\\\\SubConstructor" as type , sub_constructors.name FROM sub_constructors;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('DROP VIEW IF EXISTS companies');
    }
}
