<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bookmark extends Model
{
    /**
     * Fillable column
     *
     * @return array
     */
    protected $fillable = ['bookmarkable_id', 'bookmarkable_type', 'user_id'];

    /**
     * Get bookmarked instance
     *
     * @return MorphTo
     */
    public function bookmark()
    {
        return $this->morphTo('bookmarkable');
    }

    /**
     * Get the related user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
