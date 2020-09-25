<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use MayIFit\Core\Permission\Traits\HasCreators;

/**
 * Class Document
 *
 * @package MayIFit\Core\Permission
 */
class Document extends Model
{
    use HasCreators;

    protected $fillable = [
        'id'
    ];

    /**
     * Get the documentable model that the document belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo('documentable');
    }
}
