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
    public $timestamps = false;

    /**
     * Get all graphs associates to the curriculum
     *
     * @return HasMany
     */
    public function graphs(): HasMany
    {
        return $this->hasMany(Graph::class)->withFlash('element')->orderBy('order');
    }

    /**
     * Get all tutorials associate to this curriculum
     *
     * @return HasManyThrough
     */
    public function tutorials()
    {
        return $this->hasManyThrough(Tutorial::class, Graph::class, 'section_id', 'id', null, 'graph_id')
            ->orderBy('order');
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
