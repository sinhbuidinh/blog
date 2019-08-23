<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParcelsReceiverCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parcels', function (Blueprint $table) {
            $table->string('receiver_company')->nullable()->comment('company-receive-info')->after('time_receive');
            $table->string('value_declare')->nullable()->comment('value_parcel')->after('total_service');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('parcels', 'receiver_company'))
        {
            Schema::table('parcels', function (Blueprint $table){
                $table->dropColumn('receiver_company');
            });
        }
        if (Schema::hasColumn('parcels', 'value_declare'))
        {
            Schema::table('parcels', function (Blueprint $table){
                $table->dropColumn('value_declare');
            });
        }
    }
}
