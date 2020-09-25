<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Trait HasCreators
 *
 * @package MayIFit\Core\Permission
 */
trait HasCreators
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function createdBy(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function updatedBy(): MorphTo
    {
        return $this->morphTo();
    }
}
