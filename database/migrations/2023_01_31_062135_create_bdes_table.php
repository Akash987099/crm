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
        Schema::create('bdes', function (Blueprint $table) {
            $table->id();
            $table->string('bde_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('joining_date')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('state')->nullable();
            $table->string('document_file')->nullable();
            $table->string('status')->nullable()->default('0');
            $table->string('staff_id')->nullable();
            $table->string('staff_role')->nullable();
            $table->string('password')->nullable();
            $table->tinyInteger('archive')->nullable();
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
        Schema::dropIfExists('bdes');
    }
};
