<?php

namespace MayIFit\Core\Permission\Observers;

use Illuminate\Support\Facades\Auth;

use MayIFit\Core\Permission\Models\SystemSetting;

class SystemSettingObserver
{
    /**
     * Handle the SystemSetting "creating" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return void
     */
    public function creating(SystemSetting $model)
    {
    }

    /**
     * Handle the SystemSetting "created" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return void
     */
    public function created(SystemSetting $model)
    {
        //
    }

    /**
     * Handle the SystemSetting "saving" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return void
     */
    public function saving(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "saved" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return void
     */
    public function saved(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "updating" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return mixed
     */
    public function updating(SystemSetting $model)
    {
        $model->updatedBy()->associate(Auth::user());
    }

    /**
     * Handle the SystemSetting "updated" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return void
     */
    public function updated(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "deleting" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return mixed
     */
    public function deleting(SystemSetting $model)
    {
        //
    }

    /**
     * Handle the SystemSetting "deleted" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return void
     */
    public function deleted(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "forceDeleted" event.
     *
     * @param  \MayIFit\Core\Permission\Models\SystemSetting  $model
     * @return void
     */
    public function forceDeleted(SystemSetting $model): void
    {
        //
    }
}
