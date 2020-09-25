<?php

namespace MayIFit\Core\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use MayIFit\Core\Permission\Models\SystemSetting;

/**
 * Class SystemSettingPolicy
 *
 * @package MayIFit\Core\Permission
 */
class SystemSettingPolicy
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
        return $model->tokenCan('systemSetting.list');
    }

    /**
     * Determine whether the can view the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function view($model, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $user->tokenCan('systemSetting.view');
    }

    /**
     * Determine whether the can create roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return mixed
     */
    public function create($model)
    {
        return $model->tokenCan('systemSetting.create');
    }

    /**
     * Determine whether the can update the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function update($model, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $user->tokenCan('systemSetting.update');
    }

    /**
     * Determine whether the can delete the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function delete($model, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $user->tokenCan('systemSetting.delete');
    }

    /**
     * Determine whether the can restore the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function restore($model, SystemSetting $systemSetting)
    {
        return false;
    }

    /**
     * Determine whether the can permanently delete the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function forceDelete($model, SystemSetting $systemSetting)
    {
        return false;
    }
}
