<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use MayIFit\Core\Permission\Traits\HasPermissions;
use MayIFit\Core\Permission\Traits\HasUsers;

class Role extends Model
{
    use SoftDeletes, HasPermissions, HasUsers;

    protected $fillable = ['id', 'name', 'description', 'active', 'permissions'];

    protected $attributes = [
        'active' => true
    ];

    protected static function booted() {
        static::creating(function ($model) {
            $model->createdBy()->associate(auth()->id());
            $model->updatedBy()->associate(auth()->id());
        });
    }
   
}
