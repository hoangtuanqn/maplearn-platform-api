<?php

namespace App\Observers;

use App\Helpers\CommonHelper;
use App\Models\Document;

class DocumentObserver
{
    public function creating(Document $document)
    {
        if (empty($document->slug)) {
            $document->slug = CommonHelper::generateSlug($document->title);
        }
    }

    /**
     * Handle the Document "created" event.
     */
    public function created(Document $document): void
    {
        //
    }

    /**
     * Handle the Document "updated" event.
     */
    public function updated(Document $document): void
    {
        //
    }

    /**
     * Handle the Document "deleted" event.
     */
    public function deleted(Document $document): void
    {
        //
    }

    /**
     * Handle the Document "restored" event.
     */
    public function restored(Document $document): void
    {
        //
    }

    /**
     * Handle the Document "force deleted" event.
     */
    public function forceDeleted(Document $document): void
    {
        //
    }
}
