<?php

namespace App\Observers;

use App\Models\Document;
use Illuminate\Support\Str;

class DocumentObserver
{
    public function creating(Document $document)
    {
        if (empty($document->slug)) {
            $slugBase = Str::slug($document->title);
            // Thêm mã ngẫu nhiên 12 ký tự
            $randomSuffix = Str::random(12);
            // Gán slug
            $document->slug = $slugBase . '-' . strtolower($randomSuffix);
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
