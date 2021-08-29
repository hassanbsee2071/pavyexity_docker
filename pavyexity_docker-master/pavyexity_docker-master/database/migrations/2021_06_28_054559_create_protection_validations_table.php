<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProtectionValidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protection_validations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unique('unique_user');
            $table->timestamp('ttl')->useCurrent()->index();
            $table->longText('validation_result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protection_validations');
    }
}
