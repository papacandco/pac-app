<?php

namespace App\Models;

use App\Models\Traits\CoverUrlTrait;
use App\Models\Traits\GraphTrait;
use App\Models\Traits\HasTechnologieTrait;
use App\Models\Traits\LatestTrait;
use App\Models\Traits\PremiumTrait;
use App\Models\Traits\TaggableTrait;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutorial extends Model
{
    use CoverUrlTrait;
    use GraphTrait;
    use HasTechnologieTrait;
    use LatestTrait;
    use PremiumTrait;
    use TaggableTrait;

    /**
     * The fillable data
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'slug', 'request_by',
        'color', 'description', 'video', 'cover',
        'technologie_id', 'published', 'published_at',
        'source', 'pdf', 'duration', 'level', 'repository',
        'author_id', 'graph_id', 'duration_type', 'premium',
        'one_time', 'price',
    ];

    /**
     * The display fields
     *
     * @var array
     */
    public const SELECT_FIELD = [
        'id', 'title', 'slug', 'request_by', 'color', 'description', 'video', 'cover',
        'technologie_id', 'published_at', 'source', 'pdf', 'duration', 'level', 'repository',
        'author_id', 'graph_id', 'premium', 'one_time', 'price', 'duration_type',
    ];

    /**
     * The mutation data
     *
     * @var array
     */
    protected array $dates = ['published_at'];

    /**
     * Tutorial constructor
     *
     * @return mixed
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Tutorial::deleting(function (Tutorial $tutorial) {
            $tutorial->slug = sprintf('%s_%s', time(), $tutorial->slug);
            $tutorial->save();
            $tutorial->comments()->delete();
            $tutorial->likes()->delete();
            $tutorial->taggables()->delete();
            $tutorial->graph()->delete();
            @Material::wherePath($tutorial->cover)->delete();
        });
    }

    /**
     * Check if the tutorial is published
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->published == 1 && ! is_null($this->published_at);
    }

    /**
     * Get all comments associates to the tutorial
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get all likes associates to the tutorial
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Get the toturial author
     *
     * @return object|\App\Models\User
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * Determine if the parsed slug already exists
     *
     * @param  string  $slug
     * @return mixed
     */
    public function slugExists($slug)
    {
        return $this->where('slug', $slug)->exists();
    }

    /**
     * Determine if tutorial is associed with pdf file
     *
     * @return bool
     */
    public function withPdf()
    {
        return ! is_null($this->pdf);
    }

    /**
     * Determine if tutorial is associed with source code
     *
     * @return bool
     */
    public function withSource()
    {
        return ! is_null($this->source);
    }

    /**
     * Determine if tutorial is associed with repository
     *
     * @return bool
     */
    public function withRepository()
    {
        return ! is_null($this->repository);
    }

    /**
     * Get the list of progrestion
     *
     * @return HasMany
     */
    public function progrestions()
    {
        return $this->hasMany(Progrestion::class, 'tutorial_id');
    }

    /**
     * Determine if user have progress to
     *
     * @return Progrestion
     */
    public function progrestion(User $user)
    {
        $curriculum_id = 0;

        if ($this->graph_id) {
            $curriculum = $this->graph->section->curriculum;
            if ($user->hasBookmark($curriculum)) {
                $curriculum_id = $this->graph->section->curriculum->id;
            }
        }

        $progrestion = $this->progrestions()->where('user_id', $user->id)->first();

        if (is_null($progrestion)) {
            // Create the new progrestion
            $progrestion = $this->progrestions()->create([
                'timespent' => 0,
                'ended' => false,
                'started_at' => now(),
                'user_id' => $user->id,
                'curriculum_id' => $curriculum_id,
            ]);
        }

        return $progrestion;
    }

    /**
     * Determine if user have progress to
     *
     * @return bool
     */
    public function hasProgress(User $user)
    {
        $progrestion = $this->progrestion($user);

        return $progrestion->ended;
    }

    /**
     * __mutator
     *
     * @return string
     */
    public function getDurationAttribute(string $value)
    {
        $value = (int) $value;

        return $value.' '.$this->duration_type;
    }
}
