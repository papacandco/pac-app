<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\BelongsTo;

class Graph extends Model
{
    /**
     * Get the target section
     *
     * @param BelongsTo
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the target element
     *
     * @param BelongsTo
     */
    public function element(): BelongsTo
    {
        return $this->belongsTo($this->graph_type, 'graph_id');
    }
}
