<?php

namespace MayIFit\Core\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use MayIFit\Core\Permission\Models\Role;

/**
 * Class RolePolicy
 *
 * @package MayIFit\Core\Permission
 */
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the can view any roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return mixed
     */
    public function viewAny($model)
    {
        return $model->hasPermission('role.list');
    }

    /**
     * Determine whether the can view the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function view($model, Role $role)
    {
        return $role->name !== 'admin' && $user->tokenCan('role.view');
    }

    /**
     * Determine whether the can create roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return mixed
     */
    public function create($model)
    {
        return $model->hasPermission('role.create');
    }

    /**
     * Determine whether the can update the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function update($model, Role $role)
    {
        return $role->name !== 'admin' && $user->tokenCan('role.update');
    }

    /**
     * Determine whether the can delete the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function delete($model, Role $role)
    {
        return $role->name !== 'admin' && $user->tokenCan('role.delete');
    }

    /**
     * Determine whether the can restore the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function restore($model, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the can permanently delete the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function forceDelete($model, Role $role)
    {
        return false;
    }
}
