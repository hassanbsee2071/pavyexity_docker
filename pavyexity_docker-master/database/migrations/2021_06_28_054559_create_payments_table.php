<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('transaction_id')->index('foreign_transaction_id');
            $table->string('email')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('sender_id')->index('foreign_sender_user_id');
            $table->tinyInteger('is_guest')->default(0);
            $table->double('payment_amount', 8, 2);
            $table->integer('payment_details_id')->nullable();
            $table->string('payment_type');
            $table->string('payment_status');
            $table->tinyInteger('is_reoccuring')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
