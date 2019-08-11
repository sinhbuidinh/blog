<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guest_id');
            $table->string('guest_code');
            $table->string('parcel_code')->nullable();
            $table->string('bill_code')->nullable();
            $table->tinyInteger('type')->comment('1:tai-lieu; 2:hang-hoa')->default(1);
            $table->string('real_weight');
            $table->string('weight')->comment('kg');
            $table->string('long')->nullable();
            $table->string('wide')->nullable();
            $table->string('height')->nullable();
            $table->integer('num_package')->nullable()->comment('doivoihanghoa');
            $table->integer('type_transfer')->comment('loai-dv-phatnhanh-vantai');
            $table->longText('services')->nullable()->comment('danh-sach-dichvu-json');
            $table->string('total_service')->nullable()->comment('tong-tien-dich-vu');
            $table->dateTime('time_input')->nullable();
            $table->dateTime('time_receive')->nullable();
            $table->string('receiver')->nullable()->comment('nguoi-nhan');
            $table->string('receiver_tel')->nullable()->comment('sdt-nguoi-nhan');
            $table->string('provincial')->comment('tinh-tp');
            $table->string('district')->comment('quan-huyen');
            $table->string('ward')->comment('xa-phuong');
            $table->string('address');
            $table->string('price');
            $table->string('cod')->nullable();
            $table->string('vat');
            $table->string('price_vat');
            $table->string('refund')->nullable();
            $table->string('forward')->nullable();
            $table->string('support_gas')->comment('phuphi-xangdau');
            $table->string('support_remote')->nullable()->comment('phuphi-vungsau');
            $table->string('total')->comment('total');
            $table->longText('note')->nullable()->comment('note');
            $table->tinyInteger('status')->comment('0:deleted, 1:init, 2:package, 3:transfer, 4:refund, 5:forward, 6:complete')->default(1);
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
        Schema::dropIfExists('parcels');
    }
}
