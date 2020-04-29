<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

use MayIFit\Core\Permission\Models\Document;

/**
 * Class HasDocuments
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasDocuments {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function documents(): MorphMany {
        return $this->morphMany(Document::class, 'entity');
    }
}