<?php

namespace MayIFit\Core\Permission\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use MayIFit\Core\Permission\Models\Permission;
use MayIFit\Core\Permission\Traits\HasPermissions;
use MayIFit\Core\Permission\Traits\HasUsers;

class Role extends Model
{
    use SoftDeletes, HasPermissions, HasUsers;

   
}
