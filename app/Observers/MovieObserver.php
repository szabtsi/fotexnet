<?php

namespace App\Observers;

use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieObserver
{
    /**
     * Handle the Movie "created" event.
     */
    public function created(Movie $movie): void
    {
        //
    }

    /**
     * Handle the Movie "updated" event.
     */
    public function updating(Movie $movie): void
    {
        // If the movie's cover is being updated, delete the old cover from storage
        if ($movie->isDirty('cover')) {
            Storage::delete($movie->getOriginal('cover'));
        }
    }

    /**
     * Handle the Movie "deleted" event.
     */
    public function deleting(Movie $movie): void
    {
        // Delete the movie's cover from storage
        Storage::delete($movie->cover);
    }

    /**
     * Handle the Movie "restored" event.
     */
    public function restored(Movie $movie): void
    {
        //
    }

    /**
     * Handle the Movie "force deleted" event.
     */
    public function forceDeleted(Movie $movie): void
    {
        //
    }
}
