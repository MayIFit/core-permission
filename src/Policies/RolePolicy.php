<?php

namespace MayIFit\Core\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use MayIFit\Core\Permission\Models\Role;
use App\Models\User;

/**
 * Class RolePolicy
 *
 * @package MayIFit\Core\Permission
 */
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->tokenCan('role.list');
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $role->name !== 'admin' && $user->tokenCan('role.view');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->tokenCan('role.create');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $role->name !== 'admin' && $user->tokenCan('role.update');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $role->name !== 'admin' && $user->tokenCan('role.delete');
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        return false;
    }
}
