<?php


//use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Topicmine\Core\Models\User\Contact;

/**
 * Class UserTableSeeder
 */
class UserContactsTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $cObj = new Contact;
        $uIds = [1,2,3,4]; // 1 is Super User
        foreach($uIds as $uId)
        {
            $c = ['user_id' => $uId];
            $cObj->create($c);
        }

//        // create database with Admin user id 2
//        $db = new Database;
//        $db->dropDatabaseAndUserIfExists(1);
//        $db->createDatabase(1);
//        $db->dropDatabaseAndUserIfExists(2);
//        $db->createDatabase(2);

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}