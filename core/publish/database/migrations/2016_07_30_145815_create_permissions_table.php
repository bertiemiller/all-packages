<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
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

//        DB::table('permissions')->truncate();

        Schema::create('permissions', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('display_name')->unique();
//            $table->integer('permission_group_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

//        Schema::table('permissions', function($table) {
//            $table->foreign('permission_group_id')
//                ->references('id')
//                ->on('permission_groups')
//                ->onDelete('cascade');
//        });

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
//        Schema::table('permissions', function (Blueprint $table) {
//            $table->dropForeign('permissions_permission_group_id_foreign');
//        });
        
        Schema::drop('permissions');
    }
}
