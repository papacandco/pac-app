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
    protected array $hidden = [
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
     * @return mixed
     */
    public function commentable(): BelongsTo
    {
        return $this->belongsTo($this->commentable_type, 'commentable_id');
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
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all tags
     *
     * @return mixed
     */
    public function tags()
    {
        return $this->hasMany(Tag::class, 'taggable_id')
            ->where('taggable_type', Comment::class);
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
     * @param  string $value
     * @return mixed
     */
    public function getSourceLocationAttribute($value)
    {
        if (is_null($value)) {
            return new \stdClass();
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
