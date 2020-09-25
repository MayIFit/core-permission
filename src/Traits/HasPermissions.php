<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use MayIFit\Core\Permission\Models\Permission;

/**
 * Trait HasPermissions
 *
 * @package MayIFit\Core\Permission
 */
trait HasPermissions
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'permissionable');
    }

    public function hasPermission($permission): bool
    {
        return $this->permissions->filter(function ($p) use ($permission) {
            return $permission instanceof Permission ? $permission->is($p) : $p->name === $permission;
        })->count() > 0 ? true : false;
    }

    /**
     * @param \MayIFit\Core\Permission\Models\Permission
     */
    public function grantPermission(Permission $permission)
    {
        return $this->permissions()->attach($permission);
    }

    /**
     * @param \MayIFit\Core\Permission\Models\Permission
     */
    public function revokePermission(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }
}
