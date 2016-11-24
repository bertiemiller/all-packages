<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlScrapeUrlsTable extends Migration
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

        Schema::create('url_scrape_urls', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('url_scrape_id')->unsigned();
            $table->integer('url_id')->unsigned();

            $table->foreign('url_id')
                ->references('id')
                ->on('urls')
                ->onDelete('cascade');

            $table->foreign('url_scrape_id')
                ->references('id')
                ->on('url_scrapes')
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
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        Schema::table('url_scrape_urls', function (Blueprint $table) {
            $table->dropForeign('url_scrape_urls_url_scrape_id_foreign');
            $table->dropForeign('url_scrape_urls_url_id_foreign');
        });

        Schema::drop('url_scrape_urls');

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
