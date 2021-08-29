<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('transaction_id')->nullable();
            $table->text('transaction_type')->nullable();
            $table->unsignedInteger('user_id')->nullable()->index('foreign_tranasction_user');
            $table->double('transaction_amount', 8, 2);
            $table->string('transaction_name');
            $table->text('transaction_description');
            $table->enum('transaction_status', ['successful', 'failed', 'processing']);
            $table->text('reference_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('company_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
