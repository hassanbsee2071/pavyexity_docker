<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedTinyInteger('active')->default(1);
            $table->char('confirmation_code', 36)->nullable();
            $table->tinyInteger('confirmed')->default(1);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
