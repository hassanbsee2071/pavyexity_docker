<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_payment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_method');
            $table->string('email')->nullable();
            $table->integer('user_id')->nullable();
            $table->double('payment_amount', 8, 2);
            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            $table->unsignedInteger('account_type')->nullable();
            $table->text('bank_account_name')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('country')->nullable();
            $table->integer('zipcode')->nullable();
            $table->integer('CVV')->nullable();
            $table->unsignedInteger('month')->nullable();
            $table->unsignedInteger('year')->nullable();
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
        Schema::dropIfExists('online_payment_details');
    }
}
