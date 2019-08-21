<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_code')->nullable();
            $table->longText('parcel_list');
            $table->tinyInteger('status')->comment('0:deleted, 1:init, 2:transfer, 3:refund, 4:forward, 5:complete')->default(1);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('packages');
    }
}