<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('company_id');
            $table->string('user_id')->nullable();
            $table->text('user_mail')->nullable();
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
        Schema::dropIfExists('company_invoices');
    }
}
