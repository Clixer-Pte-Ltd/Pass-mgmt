<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubConstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_constructors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uen');
            $table->date('tenancy_start_date');
            $table->date('tenancy_end_date');
            $table->unsignedInteger('role_id')->default(SUB_CONSTRUCTOR_ROLE_ID);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unsignedInteger('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_constructors');
    }
}
