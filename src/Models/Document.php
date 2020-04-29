<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


use MayIFit\Core\Permission\Models\User;

class Document extends Model
{
    protected $table = 'uploaded_documents';

    /**
     * Get all of the users that have this document.
     */
    public function entity(): MorphTo {
        return $this->morphTo();
    }

}
