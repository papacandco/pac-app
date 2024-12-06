<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Taggable extends Model
{
    /**
     * The fillable column listing
     *
     * @var array
     */
    protected $fillable = ['tag_id', 'taggable_id', 'taggable_type'];

    /**
     * Disable the timestamp
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The trougth tag information
     *
     * @return MorphTo
     */
    public function taggable()
    {
        return $this->morphTo();
    }

    /**
     * The trougth tag information
     *
     * @return BelongsTo
     */
    public function tag()
    {
        return $this->belongsTo(Technologie::class, 'tag_id');
    }

    /**
     * The trougth tag information
     *
     * @return BelongsTo|string
     */
    public function toHtml()
    {
        $tag = $this->belongsTo(Technologie::class, 'tag_id');

        if (! $tag) {
            return '<span class="label lavel-info">Unkdown</span>';
        }

        return $this->belongsTo(Technologie::class, 'tag_id');
    }
}
