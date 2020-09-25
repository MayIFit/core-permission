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
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @return mixed
     */
    public function viewAny($authModel)
    {
        return $authModel->hasPermission('permission.list');
    }

    /**
     * Determine whether the can view the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function view($authModel, Permission $permission)
    {
        return $authModel->hasRole('permission.view');
    }

    /**
     * Determine whether the can create permissions.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @return mixed
     */
    public function create($authModel)
    {
        return false;
    }

    /**
     * Determine whether the can update the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function update($authModel, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the can delete the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function delete($authModel, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the can restore the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \App\Models\permission  $permission
     * @return mixed
     */
    public function restore($authModel, Permission $permission)
    {
        return false;
    }

    /**
     * Determine whether the can permanently delete the permission.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \App\Models\Permission  $permission
     * @return mixed
     */
    public function forceDelete($authModel, Permission $permission)
    {
        return false;
    }
}
