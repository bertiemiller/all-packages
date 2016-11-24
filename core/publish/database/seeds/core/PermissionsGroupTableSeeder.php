<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Topicmine\Core\Models\User\PermissionGroup;

class PermissionGroupsTableSeeder extends Seeder
{
    public function run()
    {

        $group_model            = PermissionGroup::class;

        // Group 1
        $permissionGroup             = new $group_model;
        $permissionGroup->name       = 'General Access';
        $permissionGroup->save();

        // Group 2
        $permissionGroup             = new $group_model;
        $permissionGroup->name       = 'User Access';
        $permissionGroup->save();

        // Group 3
        $permissionGroup             = new $group_model;
        $permissionGroup->name       = 'Data Anaytics';
        $permissionGroup->save();
        
        
        
        $permissionGroup             = new $group_model;
        $permissionGroup->name       = 'Topics';
        $permissionGroup->save();
        
        
        
        $permissionGroup             = new $group_model;
        $permissionGroup->name       = 'Inputs';
        $permissionGroup->save();

        $permissionGroup             = new $group_model;
        $permissionGroup->name       = 'Algorithms';
        $permissionGroup->save();

        $permissionGroup             = new $group_model;
        $permissionGroup->name       = 'Charts';
        $permissionGroup->save();
        
        

        
    }
}