<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pass_holders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('applicant_name');
            $table->string('nric');
            $table->date('pass_expiry_date');
            $table->unsignedInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedInteger('company_uen')->nullable();
            $table->string('ru_name');
            $table->string('ru_email');
            $table->string('as_name');
            $table->string('as_email');
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
        Schema::dropIfExists('pass_holders');
    }
}
