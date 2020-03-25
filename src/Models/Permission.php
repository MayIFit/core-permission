<?php

namespace MayIFit\Core\Permissions\Models;

use Illuminate\Database\Eloquent\Model;

use MayIFit\Core\Permissions\Models\Role;
use MayIFit\Core\Permissions\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;

    protected $table = 'permissions';

}
