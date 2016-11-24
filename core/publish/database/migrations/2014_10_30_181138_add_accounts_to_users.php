<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->tinyInteger('status')->after('password')->default(0);
            $table->integer('account_id')->unsigned();
        });

//        Schema::table('users', function($table) {
//            $table->foreign('account_id')
//                ->references('id')
//                ->on('accounts');
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
//            $table->dropForeign('users_account_id_foreign');
            $table->dropColumn('status');
            $table->dropColumn('account_id');
        });

//        Schema::table(config('access.roles_table'), function (Blueprint $table) {
//            $table->dropUnique(config('access.roles_table') . '_name_unique');
//        });
        
    }
}
