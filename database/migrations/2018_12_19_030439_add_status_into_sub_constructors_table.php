<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusIntoSubConstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_constructors', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(0)->comment('0: working, 1: working but need validate, 2: expired'); // 0: working, 1: working but need validate, 2: expired
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_constructors', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
