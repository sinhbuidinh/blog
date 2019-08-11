<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcel_id');
            $table->dateTime('date_time')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('parcel_histories');
    }
}