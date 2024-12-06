<?php

namespace App\Models;

use App\Models\Traits\HasUpdated;
use App\Models\Traits\TaggableTrait;
use Illuminate\Database\Eloquent\Collection;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $title
 */
class Question extends Model
{
    use HasUpdated;
    use SoftDeletes;
    use TaggableTrait;

    /**
     * The fillale column
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'content', 'user_id', 'curriculum_id'];

    /**
     * Question constructor
     *
     * @return mixed
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Question::deleting(function (Question $question) {
            $question->slug = sprintf('%s_%s', time(), $question->slug);
            $question->save();
            $question->comments()->delete();
        });
    }

    /**
     * Get commentaires
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get commentaires
     *
     * @return MorphMany
     */
    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    /**
     * Get curriculum
     *
     * @return BelongsTo
     */
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }

    /**
     * Get the number of comment
     *
     * @return int
     */
    public function numberOfComment()
    {
        return $this->comments()->count();
    }

    /**
     * Get commentaires
     *
     * @return MorphMany
     */
    public function lastComment()
    {
        return $this->comments->first();
    }

    /**
     * Get the forum
     *
     * @return bool
     */
    public function hasCurriculum()
    {
        return $this->curriculum_id != 0;
    }

    /**
     * Get the user
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the technologie associate to the
     *
     * @return Collection
     */
    public function technologies()
    {
        return $this->taggables()->join('technologies', 'technologies.id', 'taggables.tag_id')->select('technologies.*')->get();
    }
}
