<?php

namespace MayIFit\Core\Permission\Traits;

use MayIFit\Core\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class HasRole
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasRoles {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function roles(): BelongsToMany {
        return $this->belongstoMany(Role::class);
    }

    /**
     * @return bool
     */
    public function hasRole($role) {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
}