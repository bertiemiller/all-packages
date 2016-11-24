<?php

use App\Models\Account\Database\Database;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::setDefaultConnection('user_database');
//        DB::setDefaultConnection($newAccountConnectionKey);

//        Schema::drop('domains');
//        $db = new Database;
//        $newAccountConnectionKey = $db->getNewAccountDatabaseConnectionKey(account()->id);

//        Schema::connection($newAccountConnectionKey)->create('domains', function (Blueprint $table) {
        Schema::create('domains', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->timestamps();
//            $table->integer('account_id')->unsigned();
            $table->integer('user_id');
            $table->integer('account_id');
            $table->softDeletes();

        });

//        DB::setDefaultConnection(config('database.default'));

//        Schema::table('domains', function($table) {
//            $table->foreign('account_id')
//                ->references('id')
//                ->on('accounts')
////                ->onDelete('cascade')
//            ;
//        });

//        $table->dropForeign('posts_user_id_foreign');
//        $table->dropForeign(['user_id']);
//        Schema::enableForeignKeyConstraints();
//        Schema::disableForeignKeyConstraints();
//        DB::setDefaultConnection('mysql');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        $db = new Database;
//        $newAccountConnectionKey = $db->getNewAccountDatabaseConnectionKey(account()->id);
//        Schema::connection($newAccountConnectionKey)->drop('domains');

        Schema::drop('domains');

    }
}
