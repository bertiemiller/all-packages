<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function ($table) {
            $table->increments('id');
            $table->string('stripe_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('topics')->unisgned();
            $table->integer('domains')->default(1)->unisgned();
            $table->integer('competitors')->default(1)->unisgned();
            $table->integer('ranks')->default(0)->unisgned();
            $table->string('price')->default(0)->unisgned();
            $table->string('trial_period_days')->default(0)->unisgned();
            $table->timestamp('expires')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('plans');
    }
}
