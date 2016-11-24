<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlResultsTable extends Migration
{
    public function up()
    {
        Schema::create('url_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')->unsigned();

            // all the results....

            $table->integer('user_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('url_results');
    }
}
