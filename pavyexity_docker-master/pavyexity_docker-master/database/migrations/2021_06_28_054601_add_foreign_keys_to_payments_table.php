<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreign('sender_id', 'foreign_sender_user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('transaction_id', 'foreign_transaction_id')->references('id')->on('transactions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign('foreign_sender_user_id');
            $table->dropForeign('foreign_transaction_id');
        });
    }
}
