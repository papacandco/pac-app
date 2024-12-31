<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\BelongsTo;

class Taggable extends Model
{
    /**
     * Disable the timestamp
     *
     * @var bool
     */
    public bool $timestamps = false;

    /**
     * The trougth tag information
     *
     * @return mixed
     */
    public function taggable(): BelongsTo
    {
        return $this->belongsTo($this->taggable_type, 'taggable_id')
            ->where('taggable_type', $this->taggable_type);
    }

    /**
     * The trougth tag information
     *
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Technology::class, 'tag_id');
    }

    /**
     * The trougth tag information
     *
     * @return BelongsTo
     */
    public function toHtml(): BelongsTo
    {
        return $this->belongsTo(Technology::class, 'tag_id');
    }
}
