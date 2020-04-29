<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;

use MayIFit\Core\Permission\Models\User;

class Document extends Model
{
    protected $table = 'uploaded_documents';

    /**
     * Get all of the users that have this document.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'entity');
    }

}
