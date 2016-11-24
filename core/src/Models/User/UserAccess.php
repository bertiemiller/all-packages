<?php

namespace Topicmine\Core\Models\User;

trait UserAccess
{
    public function hasRole($nameOrId)
    {
        foreach ($this->roles as $role) {
            //First check to see if it's an ID
            if (is_numeric($nameOrId)) {
                if ($role->id == $nameOrId) {
                    return true;
                }
            }

            //Otherwise check by name
            if ($role->name == $nameOrId) {
                return true;
            }
        }

        return false;
    }
    
    public function hasRoles($roles, $needsAll = false)
    {
        if(! is_array($roles)) {
            return $this->hasRole($roles);
        }

        //User has to possess all of the roles specified
        if ($needsAll) {
            $hasRoles = 0;
            $numRoles = count($roles);

            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    $hasRoles++;
                }

            }

            return $numRoles == $hasRoles;
        }

        //User has to possess one of the roles specified
        $hasRoles = 0;
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                $hasRoles++;
            }

        }

        return $hasRoles > 0;
    }
    
    public function hasPermission($nameOrId)
    {
        return $this->allow($nameOrId);
    }
    
    public function hasPermissions($permissions, $needsAll = false)
    {
        return $this->allowMultiple($permissions, $needsAll);
    }
    
    public function attachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->attach($role);
    }
    
    public function detachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->detach($role);
    }
    
    public function attachRoles($roles)
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }
    
    public function detachRoles($roles)
    {
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }

    public function isAllowedTo($nameOrId)
    {
        if(is_super_user() || is_admin_user()) {
            return true;
        }

        // user has no permissions
        if(null == $this->permissions) {
            return false;
        }


        if(is_array($nameOrId)) {
            return $this->isAllowedToMany($nameOrId);
        }
        
        foreach ($this->roles as $role) {

            // Validate against the Permission table
            foreach ($role->permissions as $perm) {

                //First check to see if it's an ID
                if (is_numeric($nameOrId)) {
                    if ($perm->id == $nameOrId) {
                        return true;
                    }
                }

                //Otherwise check by name
                if ($perm->name == $nameOrId) {
                    return true;
                }
            }
        }

        //Check permissions directly tied to user
        foreach ($this->permissions as $perm) {

            //First check to see if it's an ID
            if (is_numeric($nameOrId)) {
                if ($perm->id == $nameOrId) {
                    return true;
                }
            }

            //Otherwise check by name
            if ($perm->name == $nameOrId) {
                return true;
            }
        }

        return false;
    }


    public function isAllowedToMany($permissions, $needsAll = false)
    {
        if(is_super_user() || is_admin_user()) {
            return true;
        }

        //User has to possess all of the permissions specified
        if ($needsAll) {
            $hasPermissions = 0;
            $numPermissions = count($permissions);

            foreach ($permissions as $perm) {
                if ($this->isAllowedTo($perm)) {
                    $hasPermissions++;
                }
            }

            return $numPermissions == $hasPermissions;
        }

        //User has to possess one of the permissions specified
        $hasPermissions = 0;
        foreach ($permissions as $perm) {
            if ($this->isAllowedTo($perm)) {
                $hasPermissions++;
            }
        }

        return $hasPermissions > 0;
    }
    
}
