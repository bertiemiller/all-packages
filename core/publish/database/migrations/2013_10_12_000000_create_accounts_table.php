<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::drop('accounts');
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->default(1);
            $table->integer('user_id')->nullable()->unsigned();
//            $table->integer('user_id')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

//        Schema::table('accounts', function($table) {
//            $table->foreign('user_id')
//                ->references('id')
//                ->on('users')
////                ->onDelete('cascade')
//            ;
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounts');
    }
}
