<?php

namespace App\Models;

use Bow\Database\Barry\Model;

class Like extends Model
{
    /**
     * Get likable target
     *
     * @return MorphTo
     */
    public function likable()
    {
        return $this->morphTo();
    }

    /**
     * Get the like author
     *
     * @return MorphTo
     */
    public function author()
    {
        return $this->morphTo('user');
    }
}
