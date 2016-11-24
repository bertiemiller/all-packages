<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlJsResultsTable extends Migration
{
    public function up()
    {
        Schema::create('url_js_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id')->unsigned();

            // all the results....

            $table->integer('user_id');
            $table->integer('account_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('url_js_results');
    }
}
