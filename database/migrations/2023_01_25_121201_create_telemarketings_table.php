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
        Schema::create('telemarketings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('cname');
            $table->string('business');
            $table->string('cemail');
            $table->string('phone');
            $table->string('meting_time');
            $table->string('services');
            $table->string('landmark');
            $table->string('address');
            $table->string('price');
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
        Schema::dropIfExists('telemarketings');
    }
};
