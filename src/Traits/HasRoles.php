<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

use MayIFit\Core\Permission\Models\Role;

/**
 * Trait HasRoles
 *
 * @package MayIFit\Core\Permission
 */
trait HasRoles
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function roles(): MorphToMany
    {
        return $this->morphToMany(Role::class, 'roleable');
    }

    /**
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->hasRole('admin');
    }

    /**
     * @param \MayIFit\Core\Permission\Models\Role
     */
    public function grantRole(Role $role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * @param \MayIFit\Core\Permission\Models\Role
     */
    public function revokeRole(Role $role)
    {
        return $this->roles()->detach($role);
    }

    public function attachDefaultRole()
    {
        return $this->roles()->attach(Role::where('default', true));
    }
}
