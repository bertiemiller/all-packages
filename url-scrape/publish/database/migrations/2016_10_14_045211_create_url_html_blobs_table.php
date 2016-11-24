<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlHtmlBlobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_html_blobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id');
            $table->longText('html_blob');
            $table->integer('user_id')->unsigned();;
            $table->integer('account_id')->unsigned();;
            $table->timestamps();

        });

        // references url_id
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('url_html_blobs');
    }
}
