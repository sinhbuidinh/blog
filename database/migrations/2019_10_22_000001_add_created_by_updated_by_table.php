<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByUpdatedByTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('birth_date');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('fails', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('user_id');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('forwards', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('user_id');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('packages', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('user_id');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('package_items', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('user_id');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('parcels', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('user_id');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('parcel_histories', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('user_id');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('transfereds', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('user_id');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('created_by')->nullable()->comment('account_create')->after('is_admin');
            $table->string('updated_by')->nullable()->comment('account_update')->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('customers', 'created_by'))
        {
            Schema::table('customers', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('customers', 'updated_by'))
        {
            Schema::table('customers', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('fails', 'created_by'))
        {
            Schema::table('fails', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('fails', 'updated_by'))
        {
            Schema::table('fails', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('forwards', 'created_by'))
        {
            Schema::table('forwards', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('forwards', 'updated_by'))
        {
            Schema::table('forwards', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('guests', 'created_by'))
        {
            Schema::table('guests', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('guests', 'updated_by'))
        {
            Schema::table('guests', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('package_items', 'created_by'))
        {
            Schema::table('package_items', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('package_items', 'updated_by'))
        {
            Schema::table('package_items', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('parcels', 'created_by'))
        {
            Schema::table('parcels', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('parcels', 'updated_by'))
        {
            Schema::table('parcels', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('parcel_histories', 'created_by'))
        {
            Schema::table('parcel_histories', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('parcel_histories', 'updated_by'))
        {
            Schema::table('parcel_histories', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('transfereds', 'created_by'))
        {
            Schema::table('transfereds', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('transfereds', 'updated_by'))
        {
            Schema::table('transfereds', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
        if (Schema::hasColumn('users', 'created_by'))
        {
            Schema::table('users', function (Blueprint $table){
                $table->dropColumn('created_by');
            });
        }
        if (Schema::hasColumn('users', 'updated_by'))
        {
            Schema::table('users', function (Blueprint $table){
                $table->dropColumn('updated_by');
            });
        }
    }
}
