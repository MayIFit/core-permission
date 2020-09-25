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
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @return mixed
     */
    public function viewAny($authModel)
    {
        return $authModel->hasPermission('role.list');
    }

    /**
     * Determine whether the can view the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function view($authModel, Role $role)
    {
        return $role->name !== 'admin' && $authModel->hasPermission('role.view');
    }

    /**
     * Determine whether the can create roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @return mixed
     */
    public function create($authModel)
    {
        return $authModel->hasPermission('role.create');
    }

    /**
     * Determine whether the can update the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function update($authModel, Role $role)
    {
        return $role->name !== 'admin' && $authModel->hasPermission('role.update');
    }

    /**
     * Determine whether the can delete the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function delete($authModel, Role $role)
    {
        return $role->name !== 'admin' && $authModel->hasPermission('role.delete');
    }

    /**
     * Determine whether the can restore the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function restore($authModel, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the can permanently delete the role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function forceDelete($authModel, Role $role)
    {
        return false;
    }
}
