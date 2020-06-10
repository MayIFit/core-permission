<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use MayIFit\Core\Permission\Models\User;

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
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
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