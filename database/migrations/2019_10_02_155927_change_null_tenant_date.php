<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullTenantDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->date('tenancy_start_date')->nullable()->change();
            $table->date('tenancy_end_date')->nullable()->change();
        });

        Schema::table('sub_constructors', function (Blueprint $table) {
            $table->date('tenancy_start_date')->nullable()->change();
            $table->date('tenancy_end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            //
        });
    }
}
