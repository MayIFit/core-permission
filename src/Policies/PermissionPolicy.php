<?php

namespace MayIFit\Core\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use MayIFit\Core\Permission\Models\Permission;

/**
 * Class PermissionPolicy
 *
 * @package MayIFit\Core\Permission
 */
class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the can view any permissions.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return mixed
     */
    public function viewAny($model)
    {
        return $model->hasPermission('permission.list');
    }

    /**
     * Determine whether the can view the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function view($model, Permission $permission)
    {
        return $model->hasRole('permission.view');
    }

    /**
     * Determine whether the can create permissions.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return mixed
     */
    public function create($model)
    {
        return false;
    }

    /**
     * Determine whether the can update the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function update($model, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the can delete the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function delete($model, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the can restore the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \App\Models\permission  $permission
     * @return mixed
     */
    public function restore($model, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the can permanently delete the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function forceDelete($model, Permission $permission)
    {
        return false;
    }
}
