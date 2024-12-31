<?php

namespace App\Models\Traits;

use App\Models\Taggable;

trait TaggableTrait
{
    /**
     * Get all tutorial taggables
     *
     * @return mixed
     */
    public function taggables(): mixed
    {
        return $this->hasMany(Taggable::class, 'taggable_id')
            ->where('taggable_type', get_class($this));
    }
}
