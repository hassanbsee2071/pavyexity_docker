<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRecurringPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recurring_payments', function (Blueprint $table) {
            $table->foreign('user_id', 'foreign_recurring_user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recurring_payments', function (Blueprint $table) {
            $table->dropForeign('foreign_recurring_user_id');
        });
    }
}
