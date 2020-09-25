<?php

namespace MayIFit\Core\Permission\Observers;

use Illuminate\Support\Facades\Auth;

use MayIFit\Core\Permission\Models\Role;

/**
 * Class RoleObserver
 *
 * @package MayIFit\Core\Permission
 */
class RoleObserver
{
    /**
     * Handle the Role "creating" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return void
     */
    public function creating(Role $model)
    {
        $model->createdBy()->associate(Auth::user());
    }

    /**
     * Handle the Role "created" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return void
     */
    public function created(Role $model)
    {
        //
    }

    /**
     * Handle the Role "saving" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return void
     */
    public function saving(Role $model): void
    {
        //
    }

    /**
     * Handle the Role "saved" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return void
     */
    public function saved(Role $model): void
    {
        //
    }

    /**
     * Handle the Role "updating" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return mixed
     */
    public function updating(Role $model)
    {
        $model->updatedBy()->associate(Auth::user());
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return void
     */
    public function updated(Role $model): void
    {
        //
    }

    /**
     * Handle the Role "deleting" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return mixed
     */
    public function deleting(Role $model)
    {
        //
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return void
     */
    public function deleted(Role $model): void
    {
        //
    }

    /**
     * Handle the Role "forceDeleted" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Role  $model
     * @return void
     */
    public function forceDeleted(Role $model): void
    {
        //
    }
}
