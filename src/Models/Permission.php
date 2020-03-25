<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Database\Eloquent\Model;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Traits\HasRoles;

class Permission extends Model
{
    use HasRoles;

    protected $table = 'permissions';

}
