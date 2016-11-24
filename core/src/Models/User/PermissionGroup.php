<?php

namespace Topicmine\Core\Models\User;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    public $table = 'permission_groups';
    
    protected $connection = 'mysql';

    public $fillable = [
        'name',
    ];

    public $relationships = [
        'permissions' => [
            'childRepo'    => 'Topicmine\Core\Repositories\User\Permission',
            'relationship' => 'permissions',
            'childRoute'        => 'topicmine.user_access.permission.index',
            'table'        => 'role_permissions',
            'headerView'   => 'core/headers/test_header.vue',
        ],
        'roles' => [
            'childRepo'    => 'Topicmine\Core\Repositories\User\Role',
            'relationship' => 'roles',
            'childRoute'        => 'topicmine.user_access.role.index',
            'table'        => 'role_permissions',
            'headerView'   => 'core/headers/test_header.vue',
        ]
    ];

    public function permissions()
    {
        return $this->belongsToMany('Topicmine\Core\Models\User\Permission',
            'permission_group_permissions', 'permission_id', 'permission_group_id');
    }

    public function roles()
    {
        return $this->belongsToMany('Topicmine\Core\Models\User\Role',
            'role_permissions', 'permission_id', 'role_id');
    }

    public function savePermissions($inputPermissions)
    {
        if (!empty($inputPermissions)) {
            $this->permissions()->sync($inputPermissions);
        } else {
            $this->permissions()->detach();
        }
    }

    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        if (is_array($permission)) {
            $permission = $permission['id'];
        }
        $this->permissions()->attach($permission);
    }

    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        if (is_array($permission)) {
            $permission = $permission['id'];
        }
        $this->permissions()->detach($permission);
    }

    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    public function detachPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            $this->detachPermission($permission);
        }
    }
    
}
