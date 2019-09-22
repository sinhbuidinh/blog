<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPictureConfirmTransferedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfereds', function (Blueprint $table) {
            $table->string('picture_confirm')->nullable()->comment('picture')->after('complete_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('transfereds', 'picture_confirm'))
        {
            Schema::table('transfereds', function (Blueprint $table){
                $table->dropColumn('picture_confirm');
            });
        }
    }
}
