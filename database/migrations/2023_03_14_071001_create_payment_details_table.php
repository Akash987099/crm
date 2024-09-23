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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->integer('type');
            $table->integer('user_type');
            $table->string('amount');
            $table->string('payment_mode');
            $table->string('payment_date');
            $table->string('created_date');
            $table->string('created_time');
            $table->string('ip_address');
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
        Schema::dropIfExists('payment_details');
    }
};
