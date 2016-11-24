<?php

namespace Topicmine\Core\Models;

use App\Account;
use Laravel\Cashier\Billable;
use App\UserRelationshipsHelper;
use Illuminate\Notifications\Notifiable;
use Topicmine\Core\Models\User\Permission;
use Topicmine\Core\Models\User\Role;
use Topicmine\Core\Models\User\UserAccess;
use Illuminate\Database\Eloquent\SoftDeletes;
use Topicmine\Core\Models\User\UserAttributes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserBase extends Authenticatable
{
    use Notifiable,
        SoftDeletes, Billable,
        UserAccess, UserAttributes, UserRelationshipsHelper;

    protected $table = 'users';

    protected $connection = 'mysql';

    public $dates = ['trial_ends_at', 'deleted_at'];

    public $fillable = [
        'name',
        'email',
        'password',
        'status',
        'confirmation_code',
        'confirmed',
        'remember_token',
        'account_id',
        'stripe_id',
        'card_brand',
        'card_last_four',
        'trial_ends_at',
        'account_id'
    ];

    public $relationships = [
        'roles' => [
            'childRepo' => 'Topicmine\Core\Repositories\User\Role',
            'relationship' => 'roles',
            'childRoute' => 'topicmine.user_access.role.index',
            'table' => 'user_roles',
            'headerView'   => 'core/headers/test_header.vue',
        ],
        'permissions' => [
            'childRepo' => 'Topicmine\Core\Repositories\User\Permission',
            'relationship' => 'permissions',
            'childRoute' => 'topicmine.user_access.permission.index',
            'table' => 'user_permissions',
            'headerView'   => 'core/headers/test_header.vue',
        ]
    ];

    public $updateFields = [
        'id',
        'name',
        'email',
        'status',
        'confirmed',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    // not sure why i need these so commenting for now
    public function getJWTIdentifier() {
        return $this->attributes['id'];
    }
    public function getJWTCustomClaims() {
        return [];
    }

}