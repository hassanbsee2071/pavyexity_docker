<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtectionShopTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protection_shop_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique('pst_unique_user');
            $table->string('number')->index();
            $table->timestamp('expires')->useCurrent()->index();
            $table->string('success_url');
            $table->string('cancel_url');
            $table->string('success_url_title');
            $table->string('cancel_url_title');
            $table->string('shop_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protection_shop_tokens');
    }
}
