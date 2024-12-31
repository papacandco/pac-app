<?php

namespace App\Models;

use App\Models\User;
use Bow\Database\Collection;
use Bow\Database\Barry\Model;
use App\Models\Traits\HasUpdated;
use App\Models\Traits\TaggableTrait;
use Bow\Database\Barry\Relations\BelongsTo;

/**
 * @property mixed $title
 * @property int $user_id
 * @property int $curriculum_id
 * @property Author $author
 */
class Question extends Model
{
    use HasUpdated;
    use TaggableTrait;

    /**
     * Question constructor
     *
     * @return mixed
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Question::deleting(
            function (Question $question) {
                $question->slug = sprintf('%s_%s', time(), $question->slug);
                $question->save();
                $question->comments()->delete();
            }
        );
    }

    /**
     * Get comments
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id')
            ->where('commentable_type', Comment::class);
    }

    /**
     * Get bookmarks
     *
     * @return mixed
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'bookmarkable_id')
            ->where('bookmarkable_type', get_class($this));
    }

    /**
     * Get curriculum
     *
     * @return BelongsTo
     */
    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

    /**
     * Get the number of comment
     *
     * @return int
     */
    public function numberOfComment(): int
    {
        return $this->comments()->count();
    }

    /**
     * Get comments
     *
     * @return mixed
     */
    public function lastComment()
    {
        return $this->comments()->first();
    }

    /**
     * Get the forum
     *
     * @return bool
     */
    public function hasCurriculum(): bool
    {
        return $this->curriculum_id != 0;
    }

    /**
     * Get the user
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the technologie associate to the
     *
     * @return Collection
     */
    public function technologies(): Collection
    {
        return $this->taggables()
            ->join('technologies', 'technologies.id', 'taggables.tag_id')
            ->select(['technologies.*'])
            ->get();
    }
}
