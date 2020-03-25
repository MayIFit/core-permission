<?php

namespace MayIFit\Permissions\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use App\User as BaseUser;
use MayIFit\Permissions\Models\Role;
use MayIFit\Permissions\Models\Permission;
use MayIFit\Permissions\Traits\Lockable;
use MayIFit\Permissions\Traits\HasRoles;
use MayIFit\Permissions\Traits\HasAdminRole;


class User extends BaseUser {
    use SoftDeletes, HasApiTokens, HasRoles, HasAdminRole, Lockable;


    /**
     * @param string $permission_name
     * @return bool
     */
    public function hasPermission($permission_name) {
        $result = DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('roles','role_user.role_id','=','roles.id')
            ->join('permission_role','roles.id','=','permission_role.role_id')
            ->join('permissions','permission_role.permission_id','=','permissions.id')
            ->select('1')->where('users.id','=', Auth::user()->id)->where('permissions.name', '=', $permission_name)->count();
        return $result > 0;
    }


}