<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

use MayIFit\Core\Permission\Models\Document;

/**
 * Class HasDocuments
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasDocuments {

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function documents(): MorphToMany {
        return $this->morphMany(Document::class, 'entity');
    }
}