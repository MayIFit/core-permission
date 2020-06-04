<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use MayIFit\Core\Permission\Traits\HasUsers;

class SystemSetting extends Model
{
    use SoftDeletes, HasUsers;

    public static function booted() {
        self::save(function(Model $model) {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });
    }
}
