<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use MayIFit\Core\Permission\Traits\HasPermissions;
use MayIFit\Core\Permission\Traits\HasUsers;

class Role extends Model
{
    use SoftDeletes, HasPermissions, HasUsers;

    protected $fillable = ['id', 'name', 'description', 'default', 'permissions'];

    protected $attributes = [
        'default_role' => false
    ];

    protected static function booted() {
        static::creating(function ($model) {
            $model->createdBy()->associate(Auth::id());
            $model->updatedBy()->associate(Auth::id());
        });
    }
   
}
