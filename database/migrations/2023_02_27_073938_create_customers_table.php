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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('user_type')->nullable();
            $table->integer('type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->string('keywords')->nullable();
            $table->longText('visiting_card')->nullable();
            $table->longText('shop_img')->nullable();
            $table->longText('amount_pic')->nullable();
            $table->string('company_service')->nullable();
            $table->integer('service_price')->nullable();
            $table->string('tenure')->nullable();
            $table->integer('blance')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('advance_amount')->nullable();
            $table->string('payment_mode')->nullable();
            $table->longText('address')->nullable();
            $table->integer('archive')->nullable();
            $table->integer('status')->nullable();
            $table->longText('remark')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
