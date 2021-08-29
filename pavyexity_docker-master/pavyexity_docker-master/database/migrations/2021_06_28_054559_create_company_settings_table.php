<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('user_id');
            $table->string('email', 50);
            $table->string('phone', 20);
            $table->string('company_name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('zipcode')->nullable();
            $table->enum('accept_payments', ['yes', 'no']);
            $table->text('EIN')->nullable();
            $table->text('api_key')->nullable();
            $table->text('api_user')->nullable();
            $table->text('api_password')->nullable();
            $table->text('token')->nullable();
            $table->dateTime('token_expired_at')->nullable();
            $table->text('global_link')->nullable();
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
        Schema::dropIfExists('company_settings');
    }
}
