<?php

namespace MayIFit\Core\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use MayIFit\Core\Permission\Models\SystemSetting;
use App\Models\User;

class SystemSettingPolicy
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
        return $user->hasPermission('systemSetting.list');
    }

    /**
     * Determine whether the user can view the systemSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function view(User $user, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $user->hasPermission('systemSetting.view');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('systemSetting.create');
    }

    /**
     * Determine whether the user can update the systemSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function update(User $user, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $user->hasPermission('systemSetting.update');
    }

    /**
     * Determine whether the user can delete the systemSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function delete(User $user, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $user->hasPermission('systemSetting.delete');
    }

    /**
     * Determine whether the user can restore the systemSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function restore(User $user, SystemSetting $systemSetting)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the systemSetting.
     *
     * @param  \App\Models\User  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function forceDelete(User $user, SystemSetting $systemSetting)
    {
        return false;
    }
}
