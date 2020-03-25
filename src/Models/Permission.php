<?php

namespace MayIFit\Permissions\Models;

use Illuminate\Database\Eloquent\Model;

use MayIFit\Permissions\Models\Role;
use MayIFit\Permissions\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;

    protected $table = 'permissions';

}
