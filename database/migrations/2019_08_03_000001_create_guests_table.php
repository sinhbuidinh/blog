<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guest_code');
            $table->string('company_name');
            $table->string('provincial')->comment('tinh-tp');
            $table->string('district')->comment('quan-huyen');
            $table->string('ward')->comment('xa-phuong');
            $table->string('address');
            $table->string('tel');
            $table->string('fax');
            $table->string('tax_code');
            $table->string('tax_address');
            $table->string('representative');
            $table->string('represent_tel');
            $table->string('represent_email');
            $table->string('price_table');
            $table->string('discount');
            $table->tinyInteger('status')->comment('0:deleted, 1:enable')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('guests');
    }
}
