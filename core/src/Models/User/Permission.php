<?php

namespace Topicmine\Core\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Topicmine\Core\Models\User\Role;
use Topicmine\Core\Models\User\PermissionGroup;

class Permission extends Model
{
    public $table = 'permissions';

    protected $connection = 'mysql';

    public $fillable = [
        'name',
        'display_name',
    ];

    public $relationships = [
        'permission_groups' => [
            'childRepo'    => 'Topicmine\Core\Repositories\User\PermissionGroup',
            'relationship' => 'permission_groups',
            'childRoute'        => 'topicmine.user_access.permission_group.index',
            'table'        => 'role_permission_groups',
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

    public function roles()
    {
        return $this->belongsToMany(Role::class,
            'role_permissions', 'permission_id', 'role_id');
    }

    public function permission_groups()
    {
        return $this->belongsToMany(PermissionGroup::class,
            'permission_group_permissions', 'permission_group_id', 'permission_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions', 'permission_id', 'user_id');
    }

    public function getPermissionGroupIdAttribute($id)
    {
        $permissionGroup = app()->make(PermissionGroup::class)->find($id);
        return $permissionGroup['name'];
    }
}
