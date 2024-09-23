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
        Schema::create('staff_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('staff_name');
            $table->string('telemarketing')->nullable();
            $table->string('marketing')->nullable();
            $table->string('client')->nullable();
            $table->string('manager')->nullable();
            $table->string('bde')->nullable();
            $table->string('call_history')->nullable();
            $table->string('check_call')->nullable();
            $table->string('coldcall')->nullable();
            $table->string('ashign_meating_client')->nullable();
            $table->string('meeting_response')->nullable();
            $table->string('our_service')->nullable();
            $table->integer('archive')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('staff_roles');
    }
};
