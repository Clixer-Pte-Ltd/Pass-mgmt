<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\PassHolder;

class AddStatusPassHolder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pass_holders', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(PassHolder::WORKING)->comment(PassHolder::WORKING . ': working, ' . PassHolder::BLACK_LIST .':blacklist'); // 0: working, 1 expired
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
            $table->dropColumn('status');
        });
    }
}
