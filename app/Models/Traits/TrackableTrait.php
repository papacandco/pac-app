<?php

namespace App\Models\Traits;

use App\ActionTracker;

trait TrackableTrait
{
    /**
     * Get the track info
     *
     * @return mixed
     */
    public function track()
    {
        return $this->morphOne(ActionTracker::class, 'trackable');
    }
}
