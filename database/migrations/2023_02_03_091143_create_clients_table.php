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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id')->nullable();
            $table->string('client_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->uniqid()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('meating_time')->nullable();
            $table->string('meating_date')->nullable();
            $table->string('service')->nullable();
            $table->string('assign_meating')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
