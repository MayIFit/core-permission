<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use MayIFit\Core\Permission\Models\Permission;

/**
 * Class HasPermissions
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasPermissions {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function permissions(): BelongsToMany {
        return $this->belongstoMany(Permission::class);
    }

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permissionName, $permissionMethod) {
        $result = Auth::user()->whereHas('roles.permissions', function($q) use($permissionName, $permissionMethod) {
            $q->where([
                'permissions.name' => $permissionName,
                'permissions.method' => $permissionMethod,
            ]);
        })->orWhereHas('permissions', function($q) use($permissionName, $permissionMethod) {
            $q->where([
                'permissions.name' => $permissionName,
                'permissions.method' => $permissionMethod,
            ]);
        })->find(Auth::id());

        return $result ? true : false;
    }
}