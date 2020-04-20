<?php

namespace MayIFit\Core\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use MayIFit\Core\Permission\Models\User;

class UserPolicy
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
        return $user->hasPermission('user.list');
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->hasPermission('user.view') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('user.create');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->hasPermission('user.update') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->hasPermission('user.delete') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can restore the user.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the user.
     *
     * @param  \MayIFit\Core\Permission\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return false;
    }
}
