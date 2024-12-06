<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\HasMany;

class Author extends Model
{
    /**
     * The fillable columns
     *
     * @var array
     */
    protected $fillable = ['pseudo', 'email', 'name', 'description'];

    /**
     * Get the list tutorials
     */
    public function tutorials(): HasMany
    {
        return $this->hasMany(Tutorial::class, 'author_id');
    }

    /**
     * __mutation
     */
    public function getAvatarAttribute(): string
    {
        return gravatar($this->email, 50);
    }
}
