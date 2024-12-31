<?php

namespace App\Models\Traits;

use App\Models\Technology;
use Bow\Database\Barry\Relations\BelongsTo;

trait HasTechnologyTrait
{
    /**
     * Get catogory reference
     *
     * @return BelongsTo;
     */
    public function technologie(): BelongsTo
    {
        return $this->belongsTo(Technology::class, 'technology_id');
    }
}
