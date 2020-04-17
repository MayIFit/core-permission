<?php

namespace MayIFit\Core\Permission\Traits;

use MayIFit\Core\Permission\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class HasUsers
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasUsers {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongstoMany
     */
    public function users(): BelongsToMany {
        return $this->belongstoMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy(): BelongsTo {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}