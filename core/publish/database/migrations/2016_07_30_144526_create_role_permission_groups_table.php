<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission_groups', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->integer('permission_group_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            
        });

        Schema::table('role_permission_groups', function($table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_permission_groups', function (Blueprint $table) {
            $table->dropForeign('role_permission_groups_role_id_foreign');
        });

        Schema::drop('role_permission_groups');
    }
}
