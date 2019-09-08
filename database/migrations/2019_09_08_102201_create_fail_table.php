<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parcel_id');
            $table->integer('reason')->nullable()->comment('1: Người nhận không nghe máy, 2: Đóng cửa, 3: Không tồn tại người nhận ở địa chỉ, 4: Người nhận chuyển địa chỉ, 5: Người nhận từ chối nhận, 6: Không tìm thấy địa chỉ, 7: Địa chi sai, 8: Lý do khác');
            $table->dateTime('fail_time')->nullable();
            $table->string('fail_note')->nullable()->comment('ghi-chu');
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
        Schema::dropIfExists('fails');
    }
}
