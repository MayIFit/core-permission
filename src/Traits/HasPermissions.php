<?php

namespace MayIFit\Core\Permission\Traits;

use MayIFit\Core\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}