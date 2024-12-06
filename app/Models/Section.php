<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;

    /**
     * The mass assignable column
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'order', 'curriculum_id'];

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
    public function graphs()
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
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}
