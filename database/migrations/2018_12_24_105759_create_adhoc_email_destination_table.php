<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdhocEmailDestinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adhoc_email_destination', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('adhoc_email_id');
            $table->foreign('adhoc_email_id')->references('id')->on('adhoc_emails')->onDelete('cascade');
            $table->unsignedInteger('company_uen');
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
        Schema::dropIfExists('adhoc_email_destination');
    }
}
