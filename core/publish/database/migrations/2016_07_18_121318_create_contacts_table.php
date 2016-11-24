<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::drop('address');
//        DB::table('address')->truncate();
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('name')->nullable(); // need this to avoid ordering error un Vuetable (not in fillable fields)
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('town')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('organisation_name')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('tel')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('default')->default(true);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });


        /*
         * Enable when go live
         */
        
//        Schema::table('contacts', function($table) {
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
        Schema::drop('contacts');
    }
}
