<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;

use MayIFit\Core\Permission\Traits\HasCreators;

/**
 * Class SystemSetting
 *
 * @package MayIFit\Core\Permission
 */
class SystemSetting extends Model
{
    use HasCreators;

    protected $attributes = [
        'public' => false
    ];
}
