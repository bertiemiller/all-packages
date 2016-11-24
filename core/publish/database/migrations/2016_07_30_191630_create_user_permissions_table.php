<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        Schema::create('user_permissions', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('user_id')->unsigned();
            
            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        if (env('DB_CONNECTION') == 'mysql') {
//            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//        }

        Schema::table('user_permissions', function (Blueprint $table) {
            $table->dropForeign('user_permissions_permission_id_foreign');
            $table->dropForeign('user_permissions_user_id_foreign');
        });

        Schema::drop('user_permissions');

//        if (env('DB_CONNECTION') == 'mysql') {
//            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        }
    }
}
