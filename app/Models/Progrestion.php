<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\BelongsTo;

class Progrestion extends Model
{
    /**
     * Get the user associate to progrestion
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user associate to progrestion
     *
     * @return BelongsTo
     */
    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class, 'tutorial_id');
    }

    /**
     * Get the user associate to progrestion
     *
     * @return BelongsTo
     */
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }
}
