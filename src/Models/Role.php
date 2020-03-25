<?php

namespace MayIFit\Core\Permissions\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use MayIFit\Core\Permissions\Models\Permission;
use MayIFit\Core\Permissions\Traits\HasPermissions;
use MayIFit\Core\Permissions\Traits\HasUsers;

class Role extends Model
{
    use SoftDeletes, HasPermissions, HasUsers;

   
}
