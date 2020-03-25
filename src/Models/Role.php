<?php

namespace MayIFit\Permissions\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use MayIFit\Permissions\Models\Permission;
use MayIFit\Permissions\Traits\HasPermissions;
use MayIFit\Permissions\Traits\HasUsers;

class Role extends Model
{
    use SoftDeletes, HasPermissions, HasUsers;

   
}
