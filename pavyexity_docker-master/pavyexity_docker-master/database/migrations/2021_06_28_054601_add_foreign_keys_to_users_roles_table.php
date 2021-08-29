<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_roles', function (Blueprint $table) {
            $table->foreign('role_id', 'foreign_role')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id', 'foreign_user')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_roles', function (Blueprint $table) {
            $table->dropForeign('foreign_role');
            $table->dropForeign('foreign_user');
        });
    }
}
