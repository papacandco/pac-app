<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Graph extends Model
{
    /**
     * The mass assignable columns
     *
     * @var array
     */
    protected $fillable = ['order', 'graph_type', 'graph_id', 'section_id'];

    /**
     * Get the target section
     *
     * @param BelongsTo
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the target element
     *
     * @param MorphTo
     */
    public function element()
    {
        return $this->morphTo('graph');
    }
}
