<?php

namespace MayIFit\Core\Permission\Traits;

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
    public function hasPermission($permission) {
        $permission = explode('.', $permission);
        if (!is_array($permission)) {
            return false;
        }
       
        $permissionName = $permission[0];
        $permissionMethod = $permission[1];
        $result = \Auth::user()->whereHas('roles.permissions', function($q) use($permissionName, $permissionMethod) {
            $q->where([
                'permissions.name' => $permissionName,
                'permissions.method' => $permissionMethod,
            ]);
        })->find(\Auth::id());

        return $result ? true : false;
    }
}