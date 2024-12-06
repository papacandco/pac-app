<?php

namespace App\Models\Traits;

use App\Models\Technologie;

trait HasTechnologieTrait
{
    /**
     * Get catogory reference
     *
     * @return \Bow\Database\Barry\Relations\BelongsTo;
     */
    public function technologie()
    {
        return $this->belongsTo(Technologie::class, 'technologie_id');
    }
}
