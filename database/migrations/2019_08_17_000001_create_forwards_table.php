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
            $table->string('forward_provincial')->comment('tinh-tp');
            $table->string('forward_district')->comment('quan-huyen');
            $table->string('forward_ward')->comment('xa-phuong');
            $table->string('forward_address');
            $table->dateTime('forward_time_receive')->nullable();
            $table->string('forward_receiver')->nullable()->comment('nguoi-nhan-thuc');
            $table->string('forward_note')->nullable()->comment('ghi-chu');
            $table->tinyInteger('forward_status')->comment('0:deleted, 1:enable')->default(1);
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
        Schema::dropIfExists('forwards');
    }
}
