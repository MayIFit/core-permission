<?php

namespace MayIFit\Core\Permission\Traits;

/**
 * Class HasPermissions
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasPermissions {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function permissions() {
        return $this->belongstoMany(Permission::class);
    }
}