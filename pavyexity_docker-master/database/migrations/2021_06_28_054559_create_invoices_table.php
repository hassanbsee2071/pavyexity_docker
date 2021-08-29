<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number');
            $table->string('invoice_title');
            $table->integer('amount');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('invoice_date')->nullable();
            $table->enum('status', ['sent', 'paid'])->nullable()->default('sent');
            $table->string('file_name');
            $table->text('jsondata');
            $table->enum('is_recurring', ['1', '0'])->default('0');
            $table->string('recurring_period')->nullable();
            $table->date('recurrring_end_date')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
