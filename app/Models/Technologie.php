<?php

namespace App\Models;

use App\Models\Traits\BookmarkTrait;
use App\Models\Traits\CoverUrlTrait;
use App\Models\Traits\FindByTrait;
use Illuminate\Database\Eloquent\Builder;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technologie extends Model
{
    use BookmarkTrait;
    use CoverUrlTrait;
    use FindByTrait;
    use SoftDeletes;

    /**
     * The level of curriculum
     *
     * @var array
     */
    public const TYPE = [
        0 => 'Frontend',
        1 => 'Backend',
        2 => 'Outils',
        3 => 'Cloud',
        4 => 'Sys Admin',
        5 => 'DevOps',
        6 => 'DevSecOps',
    ];

    /**
     * The fillable data
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'parent_id', 'color', 'description', 'cover', 'with_forum', 'published_at',
    ];

    /**
     * Hidden field
     *
     * @var array
     */
    protected $hidden = ['tutorials', 'updated_at', 'created_at'];

    /**
     * The mutation data
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * Technologie constructor
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Technologie::deleted(function (Technologie $techonologie) {
            @Material::wherePath($techonologie->cover)->delete();
        });
    }

    /**
     * Load the query forum technologie associate with forum
     *
     * @return Builder
     */
    public function withForum()
    {
        return $this->whereWithForum(true);
    }

    /**
     * Get all tutorials associates to the technologie
     *
     * @return HasMany
     */
    public function tutorials()
    {
        return $this->hasMany(Tutorial::class, 'technologie_id');
    }

    /**
     * Get all comments of tutorial associate to this technologie
     */
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Tutorial::class, 'technologie_id', 'commentable_id')
            ->where('commentable_type', Tutorial::class);
    }

    /**
     * Get all likes of tutorial associate to this technologie
     */
    public function likes(): HasManyThrough
    {
        return $this->hasManyThrough(Like::class, Tutorial::class, 'technologie_id', 'likable_id')
            ->where('likable_type', Tutorial::class);
    }

    /**
     * Get the question
     */
    public function questions(): MorphMany
    {
        return $this->morphMany(Question::class, 'forumable');
    }

    /**
     * Check if is parent
     */
    public function isParent(): bool
    {
        return $this->parent_id == 0;
    }

    /**
     * Check if is child
     */
    public function isChild(): bool
    {
        return $this->parent_id > 0;
    }

    /**
     * Check if has parent
     */
    public function technologies(): HasMany
    {
        return $this->hasMany(Technologie::class, 'parent_id', 'id');
    }
}
