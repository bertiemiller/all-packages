<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashierColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {

            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('stripe_id');
            $table->dropColumn('card_brand');
            $table->dropColumn('card_last_four');
            $table->dropColumn('trial_ends_at');

        });
    }


//    public function up()
//    {
//        Schema::table('users', function(Blueprint $table)
//        {
//            $table->tinyInteger('stripe_active')->default(0);
//            $table->string('stripe_id')->nullable();
//            $table->string('stripe_subscription')->nullable();
//            $table->string('stripe_plan', 100)->nullable();
//            $table->string('last_four', 4)->nullable();
//            $table->timestamp('trial_ends_at')->nullable();
//            $table->timestamp('subscription_ends_at')->nullable();
//
//            $table->string('card_brand')->nullable();
//        });
//    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
//    public function down()
//    {
//        Schema::table('users', function(Blueprint $table)
//        {
//            $table->dropColumn(
//                'stripe_active', 'stripe_id', 'stripe_subscription', 'stripe_plan', 'last_four', 'trial_ends_at', 'subscription_ends_at'
//            );
//
//            $table->dropColumn('card_brand');
//
////            $table->dropColumn('stripe_id');
////            $table->dropColumn('card_brand');
////            $table->dropColumn('card_last_four');
////            $table->dropColumn('trial_ends_at');
//        });
//    }
    
}
