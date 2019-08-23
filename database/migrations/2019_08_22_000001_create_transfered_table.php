<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfereds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parcel_id');
            $table->string('complete_receiver')->comment('nguoi-nhan');
            $table->string('complete_receiver_tel')->nullable()->comment('sdt-nguoi-nhan');
            $table->dateTime('complete_receive_time')->nullable();
            $table->string('complete_note')->nullable()->comment('ghi-chu');
            $table->integer('user_id')->nullable()->comment('last_action_user');
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
        Schema::dropIfExists('transfereds');
    }
}
