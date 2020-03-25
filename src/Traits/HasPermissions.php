<?php

namespace MayIFit\Core\Permissions\Traits;

/**
 * Class HasPermissions
 *
 * @package MayIFit\Core\Permissions\Traits
 */
trait HasPermissions {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function permissions() {
        return $this->belongstoMany(Permission::class);
    }
}