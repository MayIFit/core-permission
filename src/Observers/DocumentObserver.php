<?php

namespace MayIFit\Core\Permission\Observers;

use Illuminate\Support\Facades\Auth;

use MayIFit\Core\Permission\Models\Document;

class DocumentObserver
{
    /**
     * Handle the Document "creating" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return void
     */
    public function creating(Document $model)
    {
        $model->createdBy()->associate(Auth::user());
    }

    /**
     * Handle the Document "created" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return void
     */
    public function created(Document $model)
    {
        //
    }

    /**
     * Handle the Document "saving" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return void
     */
    public function saving(Document $model): void
    {
        //
    }

    /**
     * Handle the Document "saved" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return void
     */
    public function saved(Document $model): void
    {
        //
    }

    /**
     * Handle the Document "updating" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return mixed
     */
    public function updating(Document $model)
    {
        //
    }

    /**
     * Handle the Document "updated" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return void
     */
    public function updated(Document $model): void
    {
        //
    }

    /**
     * Handle the Document "deleting" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return mixed
     */
    public function deleting(Document $model)
    {
        //
    }

    /**
     * Handle the Document "deleted" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return void
     */
    public function deleted(Document $model): void
    {
        //
    }

    /**
     * Handle the Document "forceDeleted" event.
     *
     * @param  \MayIFit\Core\Permission\Models\Document  $model
     * @return void
     */
    public function forceDeleted(Document $model): void
    {
        //
    }
}
