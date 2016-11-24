<?php

namespace Topicmine\Core\Models\User;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'roles';

    protected $connection = 'mysql';

    public $fillable = [
        'name',
    ];

    public $relationships = [
        'permission_groups' => [
            'childRepo'    => 'Topicmine\Core\Repositories\User\PermissionGroup',
            'relationship' => 'permission_groups',
            'childRoute'   => 'topicmine.user_access.permission_group.index',
            'table'        => 'role_permission_groups',
            'headerView'   => 'core/headers/test_header.vue',
        ],
        'permissions' => [
            'childRepo'    => 'Topicmine\Core\Repositories\User\Permission',
            'relationship' => 'permissions',
            'childRoute'   => 'topicmine.user_access.permission.index',
            'table'        => 'role_permissions',
            'headerView'   => 'core/headers/test_header.vue',
        ]
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany('Topicmine\Core\Models\User\Permission',
            'role_permissions', 'role_id', 'permission_id')
            ->orderBy('display_name', 'asc');
    }

    public function permission_groups()
    {
        return $this->belongsToMany('Topicmine\Core\Models\User\PermissionGroup',
            'role_permission_groups', 'role_id', 'permission_group_id');
    }

    public function savePermissions($inputPermissions)
    {
        if (!empty($inputPermissions))
        {
            $this->permissions()->sync($inputPermissions);
        } else
        {
            $this->permissions()->detach();
        }
    }

    public function attachPermission($permission)
    {
        if (is_object($permission))
        {
            $permission = $permission->getKey();
        }
        if (is_array($permission))
        {
            $permission = $permission['id'];
        }
        $this->permissions()->attach($permission);
    }

    public function detachPermission($permission)
    {
        if (is_object($permission))
        {
            $permission = $permission->getKey();
        }
        if (is_array($permission))
        {
            $permission = $permission['id'];
        }
        $this->permissions()->detach($permission);
    }

    public function attachPermissions($permissions)
    {
        foreach ($permissions as $permission)
        {
            $this->attachPermission($permission);
        }
    }

    public function detachPermissions($permissions)
    {
        foreach ($permissions as $permission)
        {
            $this->detachPermission($permission);
        }
    }

}
