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
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @return mixed
     */
    public function viewAny($authModel)
    {
        return $authModel->hasPermission('systemSetting.list');
    }

    /**
     * Determine whether the can view the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function view($authModel, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $authModel->hasPermission('systemSetting.view');
    }

    /**
     * Determine whether the can create roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @return mixed
     */
    public function create($authModel)
    {
        return $authModel->hasPermission('systemSetting.create');
    }

    /**
     * Determine whether the can update the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function update($authModel, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $authModel->hasPermission('systemSetting.update');
    }

    /**
     * Determine whether the can delete the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function delete($authModel, SystemSetting $systemSetting)
    {
        return $systemSetting->name !== 'admin' && $authModel->hasPermission('systemSetting.delete');
    }

    /**
     * Determine whether the can restore the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function restore($authModel, SystemSetting $systemSetting)
    {
        return false;
    }

    /**
     * Determine whether the can permanently delete the systemSetting.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $authModel
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $systemSetting
     * @return mixed
     */
    public function forceDelete($authModel, SystemSetting $systemSetting)
    {
        return false;
    }
}
