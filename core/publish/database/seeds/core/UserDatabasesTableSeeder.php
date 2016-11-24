<?php

//use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Topicmine\Core\Models\Account\Database;

/**
 * Class UserTableSeeder
 */
class UserDatabasesTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // create database with Admin user id 2
        $db = new Database;
        $db->dropDatabaseAndUserIfExists(1);
        $db->createDatabase(1);
        $db->dropDatabaseAndUserIfExists(2);
        $db->createDatabase(2);

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}