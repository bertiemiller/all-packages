<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reason');
            $table->string('rating');
            $table->integer('user_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('subscription_id')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

//        Schema::table('cancellations', function($table) {
//            $table->foreign('account_id')
//                ->references('id')
//                ->on('accounts')
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
        Schema::drop('cancellations');
    }
}
