<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSmtpSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smtp_setting', function (Blueprint $table) {
            //
            $table->string('driver')->nullable();
            $table->string('from_address')->nullable();
            $table->string('from_name')->nullable();
            $table->string('encryption')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smtp_setting', function (Blueprint $table) {
            //
        });
    }
}
