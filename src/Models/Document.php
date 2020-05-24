<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{

    protected $fillable = ['id'];
    
     /**
     * Get the documentable model that the document belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function documentable(): MorphTo {
        return $this->morphTo('documentable');
    }

    protected static function booted() {
        static::creating(function ($model) {
            $model->createdBy()->associate(auth()->id());
            $model->updatedBy()->associate(auth()->id());
        });
    }

}
