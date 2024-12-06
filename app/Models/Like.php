<?php

namespace App\Models;

use Bow\Database\Barry\Model;

class Like extends Model
{
    /**
     * The fillbale column
     *
     * @var array
     */
    protected $fillable = ['likable_id', 'likable_type', 'user_id', 'user_type'];

    /**
     * Get likable target
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function likable()
    {
        return $this->morphTo();
    }

    /**
     * Get the like author
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function author()
    {
        return $this->morphTo('user');
    }
}
