<?php

namespace MayIFit\Core\Permission\Traits;

use DateInterval;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;

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
        return $this->cache->remember('permissions', DateInterval::createFromDateString('24 hours'), function () {
            return $this->morphToMany(Permission::class, 'permissionable')->with('roles')->get();
        });
    }

    /**
     * @param \MayIFit\Core\Permission\Models\Permission|string  $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        $permissionName = '';
        $permissionMethod = '';

        if (method_exists(Auth::user(), 'hasRole')) {
            if (Auth::user()->hasRole('admin')) {
                return true;
            }
        }

        if (!$permission instanceof Permission) {
            [$permissionName, $permissionMethod] = explode('.', $permission);
            if (config('core-permission.check_token_for_permission') === TRUE) {
                return Auth::user()->tokenCan($permission);
            }
        };

        return $this->permissions->filter(function ($p) use ($permissionName, $permissionMethod, $permission) {
            return $permission instanceof Permission ? $permission->is($p) : ($p->name === $permissionName && $p->method === $permissionMethod);
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
