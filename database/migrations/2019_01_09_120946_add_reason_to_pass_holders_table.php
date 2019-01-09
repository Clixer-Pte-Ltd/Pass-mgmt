<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonToPassHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pass_holders', function (Blueprint $table) {
            $table->string('blacklist_reason')->nullable();
            $table->string('terminate_reason')->nullable();
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
            $table->dropColumn('terminate_reason');
            $table->dropColumn('blacklist_reason');
        });
    }
}
