<?php

namespace App\Models\Traits;

use App\Models\Bookmark;
use Bow\Database\Barry\Model;

trait BookmarkTrait
{
    /**
     * The followers
     *
     * @return mixed
     */
    public function followers()
    {
        return $this->hasMany(Bookmark::class, 'bookmarkable_id')
            ->where('bookmarkable_type', get_class($this));
    }

    /**
     * Check the marked
     *
     * @param  Model $bookmarkable
     * @return bool
     */
    public function hasBookmarked($bookmarkable)
    {
        return $this->bookmarks()
            ->where('bookmarkable_id', $bookmarkable->id)
            ->where('bookmarkable_type', get_class($bookmarkable))
            ->exists();
    }

    /**
     * Create the new bookmark
     *
     * @return mixed
     */
    public function mark($bookmarkable)
    {
        return $this->bookmarks()->create([
            'bookmarkable_id' => $bookmarkable->id,
            'bookmarkable_type' => get_class($bookmarkable),
        ]);
    }
}
