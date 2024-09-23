<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_temp', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('meetingid')->nullable();
            $table->integer('serviceid')->nullable();
            $table->string('price')->nullable();
            $table->string('created_date')->nullable();
            $table->string('created_time')->nullable();
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('service_temp');
    }
};
