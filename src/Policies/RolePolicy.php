<?php

namespace MayIFit\Core\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use MayIFit\Core\Permission\Models\Role;
use MayIFit\Core\Permission\Models\User;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('role.list');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $role->name !== 'admin' && $user->hasPermission('role.view');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('role.create');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->hasPermission('role.update');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->hasPermission('role.delete');
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        return false;
    }
}
