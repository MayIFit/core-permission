<?php

namespace MayIFit\Core\Permissions\Traits;

/**
 * Class HasUsers
 *
 * @package MayIFit\Core\Permissions\Traits
 */
trait HasUsers {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function users() {
        return $this->belongstoMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}