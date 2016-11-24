<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionGroupPermissionsTable extends Migration
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

        Schema::create('permission_group_permissions', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('permission_group_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::table('permission_group_permissions', function($table) {

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('permission_group_id')
                ->references('id')
                ->on('permission_groups')
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
        Schema::table('permission_group_permissions', function (Blueprint $table) {
            $table->dropForeign('permission_group_permissions_permission_id_foreign');
            $table->dropForeign('permission_group_permissions_permission_group_id_foreign');
        });

        Schema::drop('permission_group_permissions');
    }
}
