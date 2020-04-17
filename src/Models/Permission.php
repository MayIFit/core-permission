<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;

    protected $table = 'permissions';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'base_controller', 'controller', 'middleware', 'created_at', 'updated_at',
    ];

}
