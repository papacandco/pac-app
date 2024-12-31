<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use App\Models\Traits\LatestTrait;
use App\Models\Traits\CoverUrlTrait;
use Bow\Database\Barry\Relations\HasMany;
use Bow\Database\Barry\Relations\BelongsTo;

class Challenge extends Model
{
    use CoverUrlTrait;
    use LatestTrait;

    /**
     * The dates transformation
     *
     * @var array
     */
    protected array $dates = ['diffused_at'];

    /**
     * Challenge constructor
     *
     * @return mixed
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Challenge::deleting(fn ($challenge) => $challenge->comments()->delete());
    }

    /**
     * Get if the challenge is already diffused
     *
     * @return bool
     */
    public function isDiffused()
    {
        return $this->diffused == 1;
    }

    /**
     * Get the status
     *
     * @return mixed
     */
    public function isPending()
    {
        return $this->diffused == -1;
    }

    /**
     * Check if the challenge is in progress
     *
     * @return bool
     */
    public function inProgress()
    {
        return $this->diffused == 0;
    }

    /**
     * Get if the challenge is already diffused
     *
     * @return bool
     */
    public function isCurrentDay()
    {
        return $this->diffused_at->isCurrentDay();
    }

    /**
     * Check the challenge visibility
     *
     * @return bool
     */
    public function isPrivate()
    {
        return $this->visibility == 1;
    }

    /**
     * Get all invitation information
     *
     * @return HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(ChallengeInvite::class);
    }

    /**
     * Check if user is already guest
     *
     * @param  int $user_id
     * @return bool
     */
    public function isGuest($user_id)
    {
        return $this->invitations()->where('user_id', $user_id)->exists();
    }

    /**
     * Get a invitation information
     *
     * @param  int $user_id
     * @return ChallengeInvite
     */
    public function invitation($user_id)
    {
        return $this->invitations()->where('user_id', $user_id)->first();
    }

    /**
     * Get all comment that are assigned to the challenge
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Comment::class, 'commentable_id')
            ->where('commentable_type', Challenge::class);
    }

    /**
     * Message alias
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->messages();
    }

    /**
     * Get diffusion icon
     *
     * @return string
     */
    public function diffusionIcon(): string
    {
        if (! $this->inProgress()) {
            return '';
        }

        return '<i class="pulsate-fwd text-danger fa fa-circle"></i>';
    }

    /**
     * Get the author info
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * Get the technologie info
     *
     * @return BelongsTo
     */
    public function technologie(): BelongsTo
    {
        return $this->belongsTo(Technology::class, 'technology_id');
    }

    /**
     * Mutate title to slug
     *
     * @return string
     */
    public function getSlugAttribute()
    {
        return str_slug($this->title);
    }
}
