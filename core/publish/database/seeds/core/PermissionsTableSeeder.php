<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Topicmine\Core\Models\User\Permission;

/**
 * Class PermissionTableSeeder
 */
class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
//        if (env('DB_CONNECTION') == 'mysql') {
//            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//        }
        
        $permission_model          = Permission::class;
        
        /*
         * General Access
         */
        $accessOffice               = new $permission_model;
        $accessOffice->name         = 'access-office';
        $accessOffice->display_name = 'Access Office';
        $accessOffice->save();
        
        $viewAdmin               = new $permission_model;
        $viewAdmin->name         = 'access-admin';
        $viewAdmin->display_name = 'Access Admin';
        $viewAdmin->save();

        $viewAccessManagement               = new $permission_model;
        $viewAccessManagement->name         = 'access-user-access';
        $viewAccessManagement->display_name = 'Access User Access';
        $viewAccessManagement->save();

        $viewAnalytics               = new $permission_model;
        $viewAnalytics->name         = 'access-analytics';
        $viewAnalytics->display_name = 'Access Analytics';
        $viewAnalytics->save();
                
        /*
         * Data Analytics Access
         */        
        $viewAdmin               = new $permission_model;
        $viewAdmin->name         = 'view-data';
        $viewAdmin->display_name = 'View Data';
        $viewAdmin->save();
        
        $createAdmin               = new $permission_model;
        $createAdmin->name         = 'create-data';
        $createAdmin->display_name = 'Create Data';
        $createAdmin->save();
        
        $editAdmin               = new $permission_model;
        $editAdmin->name         = 'edit-data';
        $editAdmin->display_name = 'Edit Data';
        $editAdmin->save();

        $deleteAdmin               = new $permission_model;
        $deleteAdmin->name         = 'delete-data';
        $deleteAdmin->display_name = 'Delete Data';
        $deleteAdmin->save();
        
//        if (env('DB_CONNECTION') == 'mysql') {
//            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        }
    }
}