<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAdhocEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adhoc_emails', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(0)->comment('0: active, 1: archive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adhoc_emails', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
