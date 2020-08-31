<?php

namespace MayIFit\Core\Permission\Observers;

use MayIFit\Core\Permission\Models\SystemSetting;

class SystemSettingObserver
{
    /**
     * Handle the SystemSetting "creating" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return void
     */
    public function creating(SystemSetting $model)
    {
        $model->createdBy()->associate(auth()->id());
        $model->updatedBy()->associate(auth()->id());
    }

    /**
     * Handle the SystemSetting "created" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return void
     */
    public function created(SystemSetting $model)
    {
        //
    }

    /**
     * Handle the SystemSetting "saving" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return void
     */
    public function saving(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "saved" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return void
     */
    public function saved(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "updating" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return mixed
     */
    public function updating(SystemSetting $model)
    {
        //
    }

    /**
     * Handle the SystemSetting "updated" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return void
     */
    public function updated(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "deleting" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return mixed
     */
    public function deleting(SystemSetting $model)
    {
        //
    }

    /**
     * Handle the SystemSetting "deleted" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return void
     */
    public function deleted(SystemSetting $model): void
    {
        //
    }

    /**
     * Handle the SystemSetting "forceDeleted" event.
     *
     * @param  \MayIFit\Extension\Shop\Models\SystemSetting  $model
     * @return void
     */
    public function forceDeleted(SystemSetting $model): void
    {
        //
    }
}
