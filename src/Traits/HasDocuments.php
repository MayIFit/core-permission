<?php

namespace MayIFit\Core\Permission\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use MayIFit\Core\Permission\Models\Document;

/**
 * Class HasDocuments
 *
 * @package MayIFit\Core\Permission\Traits
 */
trait HasDocuments {

    /**
     * Get the documents that belong to model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function documents(): MorphMany {
        return $this->morphMany(Document::class, 'documentable')->where('type', 'not like', '%image%');
    }

    /**
     * Get the document that belong to model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function document(): MorphOne {
        return $this->morphOne(Document::class, 'documentable')->where('type', 'not like', '%image%');
    }

    /**
     * Get the images that belong to model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function images(): MorphMany {
        return $this->morphMany(Document::class, 'documentable')->where('type', 'like', '%image%');
    }

    /**
     * Get the image that belong to model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image(): MorphOne {
        return $this->morphOne(Document::class, 'documentable')->where('type', 'like', '%image%');
    }
}