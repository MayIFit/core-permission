<?php

namespace MayIFit\Core\Permission\Tests;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Sanctum\HasApiTokens;

use MayIFit\Core\Permission\Traits\HasPermissions;
use MayIFit\Core\Permission\Traits\HasRoles;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use HasApiTokens;
    use Authorizable;
    use Authenticatable;
    use HasRoles;
    use HasPermissions;

    protected $guarded = [];

    protected $table = 'users';

    protected $morphClass = 'user';
}
