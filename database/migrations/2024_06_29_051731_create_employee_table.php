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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname'); 
            $table->string('staffid');
            $table->string('desigantion_id');
            $table->string('email');
            $table->string('phone');
            $table->string('joinningdate')->date();
            $table->string('city');
            $table->string('pincode');
            $table->string('address');
            $table->string('password');
            $table->string('state');
            $table->string('image');
            $table->string('aadhar');
            $table->string('pancard');
            $table->string('aadhardoc');
            $table->string('pandoc');
            $table->string('bank');
            $table->string('bankacc');
            $table->string('ifsc');
            $table->string('bankdoc');
            $table->string('checkbook');
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
        Schema::dropIfExists('employee');
    }
};
