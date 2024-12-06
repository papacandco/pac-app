<?php

namespace App\Models\Traits;

use App\Models\Bookmark;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait BookmarkTrait
{
    /**
     * The followers
     *
     * @return MorphMany
     */
    public function followers()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    /**
     * Check the marked
     *
     * @param  Model  $bookmarkable
     * @return bool
     */
    public function hasBookmarked($bookmarkable)
    {
        return $this->bookmarks()
            ->whereBookmarkableId($bookmarkable->id)
            ->whereBookmarkableType(get_class($bookmarkable))
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
