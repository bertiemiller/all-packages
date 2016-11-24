<?php

use Carbon\Carbon;
//use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserTableSeeder
 */
class CoreUsersTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        //Add the master administrator, user id of 1
        // users 1 - 4
        $users = [
            [
                'name'              => 'Super User',
                'email'             => 'info@topicmine.io',
                'password'          => bcrypt('admin'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'account_id'        => 1,
                'status'        => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Administrator',
                'email'             => 'admin@topicmine.io',
                'password'          => bcrypt('admin'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'account_id'        => 2,
                'status'        => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Manager',
                'email'             => 'manager@topicmine.io',
                'password'          => bcrypt('manager'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'account_id'        => 2,
                'status'        => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'User',
                'email'             => 'user@topicmine.io',
                'password'          => bcrypt('user'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed'         => true,
                'account_id'        => 2,
                'status'        => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);

//        $cObj = new Contact;
//        $uIds = [1];
//        foreach($uIds as $uId)
//        {
//            $c = ['user_id' => $uId];
//            $cObj->create($c);
//        }

//        // create database
//        $db = new Database;
//        $db->dropDatabaseAndUserIfExists(1); // For Super User
//        $db->createDatabase(1);

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}