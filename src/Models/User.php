<?php

namespace MayIFit\Core\Permission\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Models\Permission;
use MayIFit\Core\Permission\Traits\Lockable;
use MayIFit\Core\Permission\Traits\HasRoles;
use MayIFit\Core\Permission\Traits\HasAdminRole;


class User extends Authenticatable {
    use HasRoles, HasAdminRole, Lockable, HasApiTokens;

    protected $dates = ['deleted_at'];

    /**
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission) {
        $permission = explode('.', $permission);
        if (!is_array($permission)) {
            return false;
        }

        $permissionName = $permission[0];
        $permissionMethod = $permission[1];
        $result = DB::table('users')
            ->join('role_user','users.id','=','role_user.user_id')
            ->join('roles','role_user.role_id','=','roles.id')
            ->join('permission_role','roles.id','=','permission_role.role_id')
            ->join('permissions','permission_role.permission_id','=','permissions.id')
            ->select('1')->where('users.id','=',$this->id)->where([
                'permissions.name' => $permissionName,
                'permissions.method' => $permissionMethod
            ])->count();
        return $result > 0;
    }

    public function getAllPermissionsAttribute() {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if ($this->hasPermission($permission->name)) {
                $permissions[] = $permission->name;
            }
        }
        return $permissions;
    }


}
