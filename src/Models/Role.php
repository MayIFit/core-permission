<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use MayIFit\Core\Permission\Traits\HasPermissions;
use MayIFit\Core\Permission\Traits\HasUsers;

/**
 * Class Role
 *
 * @package MayIFit\Core\Permission
 */
class Role extends Model
{
    use SoftDeletes, HasPermissions, HasUsers;

    protected $fillable = [
        'id',
        'name',
        'description',
        'default',
        'permissions'
    ];

    protected $attributes = [
        'default_role' => false
    ];
}
