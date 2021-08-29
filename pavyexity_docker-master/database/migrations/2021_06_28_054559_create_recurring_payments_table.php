<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecurringPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurring_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->double('payment_amount', 8, 2);
            $table->unsignedInteger('user_id')->nullable()->index('foreign_recurring_user_id');
            $table->string('intervals');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('recurring_payments');
    }
}
