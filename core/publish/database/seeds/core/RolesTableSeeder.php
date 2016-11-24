<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Topicmine\Core\Models\User\Role;

/**
 * Class RoleTableSeeder
 */
class RolesTableSeeder extends Seeder
{
    public function run()
    {
//        if (env('DB_CONNECTION') == 'mysql') {
//            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//        }
        
        //Create admin role, id of 1
        $role_model        = Role::class;
        $admin             = new $role_model;
        $admin->name       = 'SuperUser';
        $admin->default    = true;
        $admin->editable    = false;
        $admin->save();

        //Create admin role, id of 2
        $admin             = new $role_model;
        $admin->name       = 'Administrator';
        $admin->default    = true;
        $admin->editable    = false;
        $admin->save();

        //id = 3
        $user             = new $role_model;
        $user->name       = 'Manager';
        $admin->default    = true;
        $admin->editable    = true;
        $user->save();

        //id = 4
        $user             = new $role_model;
        $user->name       = 'User';
        $admin->default    = true;
        $admin->editable    = true;
        $user->save();
        
//        if (env('DB_CONNECTION') == 'mysql') {
//            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        }
    }
}