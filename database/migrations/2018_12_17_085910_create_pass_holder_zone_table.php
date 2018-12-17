<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassHolderZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pass_holder_zone', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pass_holder_id');
            $table->foreign('pass_holder_id')->references('id')->on('pass_holders')->onDelete('cascade');
            $table->unsignedInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
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
        Schema::dropIfExists('pass_holder_zone');
    }
}
