<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use Topicmine\Core\Models\User\PermissionGroup;
use Topicmine\Core\Models\User\Role;

class UserRolesAndPermissionsSeeder extends Seeder{

    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $role_model        = Role::class;

        /*
         * SU permissions
         */
        $permissionsSU = [
            'access-office',
        ];

        $permissionIdsSU = DB::table('permissions')->whereIn('name', $permissionsSU)->pluck('id');
        $role = new $role_model;
        $role::find(1)->attachPermissions($permissionIdsSU);


        /*
         * Manager permissions
         */        
        $permissionsManager = [
            'access-admin',
            'access-data-analytics',
            'create-data',
            'edit-data',
            'delete-data',
            'view-data',
        ];

        $permissionIdsManager = DB::table('permissions')->whereIn('name', $permissionsManager)->pluck('id');
        $role = new $role_model;
        $role::find(3)->attachPermissions($permissionIdsManager);


        /*
         * User permissions
         */
        $permissionsUser = [
            'access-admin',
            'access-data-analytics',
            'view-data',
        ];

        $permissionIdsUser = DB::table('permissions')->whereIn('name', $permissionsUser)->pluck('id');
        $role = new $role_model;
        $role::find(4)->attachPermissions($permissionIdsUser);

        
        /*
         * Roles
         */
        User::find(1)->attachRole(1);
        User::find(2)->attachRole(2);
        User::find(3)->attachRole(3);
        User::find(4)->attachRole(4);


        /*
         * Attach permissions to groups
         */

        $permission_group_model        = PermissionGroup::class;

        // Admin
        $adminPermissions = [
            'access-admin',
        ];

        $adminPermissionIds = DB::table('permissions')->whereIn('name', $adminPermissions)->pluck('id');
        $permission_group = new $permission_group_model;
        $permission_group::find(1)->attachPermissions($adminPermissionIds);


        // UserAccess
        $userAccessPermissions = [
            'access-user-access',
        ];

        $userAccessPermissionIds = DB::table('permissions')->whereIn('name', $userAccessPermissions)->pluck('id');
        $permission_group = new $permission_group_model;
        $permission_group::find(2)->attachPermissions($userAccessPermissionIds);


        // Data
        $dataPermissions = [
            'access-data-analytics',
            'create-data',
            'edit-data',
            'delete-data',
            'view-data',
        ];

        $dataPermissionIds = DB::table('permissions')->whereIn('name', $dataPermissions)->pluck('id');
        $permission_group = new $permission_group_model;
        $permission_group::find(3)->attachPermissions($dataPermissionIds);

        
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        
    }
}