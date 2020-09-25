<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 *
 * @package MayIFit\Core\Permission
 */
class Permission extends Model
{
    protected $table = 'permissions';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'base_controller',
        'controller',
        'middleware',
        'created_at',
        'updated_at',
    ];

    public function roles()
    {
        return $this->morphedByMany(Role::class, 'roles');
    }
}
