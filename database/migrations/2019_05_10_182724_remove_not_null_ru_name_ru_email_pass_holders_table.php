<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNotNullRuNameRuEmailPassHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pass_holders', function (Blueprint $table) {
            $table->string('ru_name')->nullable()->change();
            $table->string('ru_email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pass_holders', function (Blueprint $table) {
            $table->string('ru_name')->change();
            $table->string('ru_email')->change();
        });
    }
}
