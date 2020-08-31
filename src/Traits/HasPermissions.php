<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use MayIFit\Core\Permission\Models\Permission;
use MayIFit\Core\Permission\Models\Role;

/**
 * Trait HasPermissions
 *
 * @package MayIFit\Core\Permission
 */
trait HasPermissions
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongstoMany(Permission::class);
    }
}
