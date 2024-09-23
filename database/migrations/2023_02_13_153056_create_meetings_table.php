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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('user_id')->nullable();
            $table->string('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('keywords')->nullable();
            $table->string('address')->nullable();
            $table->string('company_service')->nullable();
            $table->string('visiting_img')->nullable();
            $table->string('shop_img')->nullable();
            $table->string('remark')->nullable();
            $table->string('archive')->nullable();
            $table->string('created_date')->nullable();
            $table->string('created_time')->nullable();
            $table->string('ip_address')->nullable();
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
        Schema::dropIfExists('meetings');
    }
};
