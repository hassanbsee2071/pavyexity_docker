<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProtectionShopTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('protection_shop_tokens', function (Blueprint $table) {
            $table->foreign('user_id', 'pst_foreign_user')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('protection_shop_tokens', function (Blueprint $table) {
            $table->dropForeign('pst_foreign_user');
        });
    }
}
