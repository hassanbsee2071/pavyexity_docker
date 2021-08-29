<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlinePaymentLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_payment_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->index('online_payment_links_user_id_foreign');
            $table->string('name');
            $table->text('hash');
            $table->tinyInteger('is_enable')->default(1);
            $table->tinyInteger('is_guest');
            $table->tinyInteger('is_fixed')->nullable();
            $table->string('amount_req', 221)->nullable();
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
        Schema::dropIfExists('online_payment_links');
    }
}
