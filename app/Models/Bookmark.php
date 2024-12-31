<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\BelongsTo;

class Bookmark extends Model
{
    /**
     * Get bookmarked instance
     *
     * @return mixed
     */
    public function bookmark(): BelongsTo
    {
        return $this->belongsTo($this->bookmarkable_type, $this->bookmarkable_id);
    }

    /**
     * Get the related user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
