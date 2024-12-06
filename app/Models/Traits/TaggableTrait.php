<?php

namespace App\Models\Traits;

use App\Models\Taggable;

trait TaggableTrait
{
    /**
     * Get all tutorial taggables
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function taggables()
    {
        return $this->morphMany(Taggable::class, 'taggable');
    }
}
