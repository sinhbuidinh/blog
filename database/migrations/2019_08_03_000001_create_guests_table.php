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
            $table->string('guest_code')->nullable();
            $table->string('company_name');
            $table->string('provincial')->comment('tinh-tp');
            $table->string('district')->comment('quan-huyen');
            $table->string('ward')->comment('xa-phuong');
            $table->string('address');
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('tax_code');
            $table->string('tax_address');
            $table->string('representative');
            $table->string('represent_tel')->nullable();
            $table->string('represent_email')->nullable();
            $table->string('price_table');
            $table->string('discount')->nullable();
            $table->tinyInteger('status')->comment('0:deleted, 1:enable')->default(1);
            $table->integer('user_id')->nullable()->('last_action_user');
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
