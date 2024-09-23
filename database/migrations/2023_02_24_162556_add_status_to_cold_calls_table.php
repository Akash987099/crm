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
        Schema::table('cold_calls', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->string('service_price')->nullable();
            $table->string('tenure')->nullable();
            $table->string('blance')->nullable();
            $table->string('discount')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('advance_amount')->nullable();
            $table->string('followup_date')->nullable();
            $table->string('amount_pic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cold_calls', function (Blueprint $table) {
            //
        });
    }
};
