<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forwards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parcel_id');
            $table->string('forward_to')->comment('nguoi-nhan');
            $table->string('forward_tel')->comment('sdt-nguoi-nhan');
            $table->string('provincial')->comment('tinh-tp');
            $table->string('district')->comment('quan-huyen');
            $table->string('ward')->comment('xa-phuong');
            $table->string('address');
            $table->dateTime('time_receive')->nullable();
            $table->string('receiver')->nullable()->comment('nguoi-nhan-thuc');
            $table->string('note')->nullable()->comment('ghi-chu');
            $table->tinyInteger('status')->comment('0:deleted, 1:enable')->default(0);
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
        Schema::dropIfExists('forwards');
    }
}
