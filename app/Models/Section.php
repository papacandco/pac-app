<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\HasMany;
use Bow\Database\Barry\Relations\BelongsTo;

class Section extends Model
{
    /**
     * Disable timestamps
     *
     * @var bool
     */
    public bool $timestamps = false;

    /**
     * Get all graphs associates to the curriculum
     *
     * @return HasMany
     */
    public function graphs(): HasMany
    {
        return $this->hasMany(Graph::class, 'section_id')->orderBy('graphs.order', 'asc');
    }

    /**
     * Get all tutorials associate to this curriculum
     *
     * @return HasMany
     */
    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class, 'graphs.section_id')
            ->join("graphs", 'graphs.graph_id', 'tutorials.id')
            ->where('graphs.graph_type', Tutorial::class)
            ->orderBy('graphs.order', 'asc');
    }

    /**
     * Get the target curriculum
     *
     * @param BelongsTo
     */
    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }
}
