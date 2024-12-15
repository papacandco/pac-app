<?php

namespace App\Models;

use Spatie\Sitemap\Tags\Tag;
use Bow\Database\Barry\Model;
use App\Models\Traits\HasUpdated;
use App\Models\Traits\LatestTrait;
use Bow\Database\Barry\Relations\HasMany;
use Bow\Database\Barry\Relations\BelongsTo;
use App\Notifications\ReplyCommentNotification;

class Comment extends Model
{
    use HasUpdated;
    use LatestTrait;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'commentable_type', 'commentable_id', 'source_ip', 'source_client', 'source_referer', 'source_location',
    ];

    /**
     * Comment constructor
     *
     * @return mixed
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Comment::deleting(function (Comment $comment) {
            if ($comment->isParent()) {
                $comment->comments()->delete();
            }
        });
    }

    /**
     * Get commentable target
     *
     * @return MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get commentables target
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get the comment author
     *
     * @return MorphTo
     */
    public function user()
    {
        return $this->morphTo('user');
    }

    /**
     * Check if is commented by anonymous user
     *
     * @return bool
     */
    public function isAnonymous()
    {
        return $this->user_type == Anonymous::class;
    }

    /**
     * Get all tags
     *
     * @return MorphMany
     */
    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * Get all like that are assign to the comment
     *
     * @return MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Check if the comment is for tutorial
     *
     * @return bool
     */
    public function isForTutorial()
    {
        return $this->commentable_type == Tutorial::class;
    }

    /**
     * Check if the comment is for question
     *
     * @return bool
     */
    public function isForQuestion()
    {
        return $this->commentable_type == Question::class;
    }

    /**
     * Check if the comment is for podcast
     *
     * @return bool
     */
    public function isForPodcast()
    {
        return $this->commentable_type == Podcast::class;
    }

    /**
     * Check if the comment is for challenge
     *
     * @return bool
     */
    public function isForChallenge()
    {
        return $this->commentable_type == Challenge::class;
    }

    /**
     * Check if the comment have the comment parent
     *
     * @return bool
     */
    public function isParent()
    {
        return $this->parent_id !== 0;
    }

    /**
     * Get the comment parent
     *
     * @return BelongsTo description
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * __mutator
     *
     * @param  string  $value
     * @return mixed
     */
    public function getSourceLocationAttribute($value)
    {
        if (is_null($value)) {
            return new \stdClass;
        }

        return json_decode($value);
    }

    /**
     * Send reply comment notification
     *
     * @return void
     */
    public function notifiyParentAuthor()
    {
        if (! $this->isParent()) {
            return;
        }

        if (! is_null($this->parent)) {
            if ($this->parent->user_id !== $this->user_id) {
                $this->parent->user->notify(new ReplyCommentNotification($this->parent, $this));
            }
        }
    }
}
