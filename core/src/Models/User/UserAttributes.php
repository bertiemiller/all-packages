<?php

namespace Topicmine\Core\Models\User;

use Topicmine\Core\Models\User\Role;
use Route;

trait UserAttributes
{
    public function getRoleIdAttribute($id)
    {
        $role = app()->make(Role::class)->find($id);
        return $role['name'];
    }

    public function isActive() {
        return $this->status == 1;
    }

    public function isConfirmed() {
        return $this->confirmed == 1;
    }

    public function isSuperUser()
    {
        return !! $this->hasRole(1);
    }

    public function isAdministrator()
    {
        return !! $this->hasRole(2);
    }

    public function isAdmin()
    {
        return $this->isAdministrator();
    }

    public function isManager()
    {
        return !! $this->hasRole(3);
    }

    public function isUser()
    {
        return !! $this->hasRole(4);
    }
}
