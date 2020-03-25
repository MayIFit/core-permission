<?php

namespace MayIFit\Permissions\Traits;

/**
 * Class HasPermissions
 *
 * @package MayIFit\Permissions\Traits
 */
trait HasPermissions {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function permissions() {
        return $this->belongstoMany(Permission::class);
    }
}