<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;

use MayIFit\Core\Permission\Traits\HasUsers;

/**
 * Class SystemSetting
 *
 * @package MayIFit\Core\Permission
 */
class SystemSetting extends Model
{
    use HasUsers;

    protected $attributes = [
        'public' => false
    ];

    public static function booted()
    {
        self::creating(function (Model $model) {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });
    }
}
