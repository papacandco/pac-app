<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use App\Models\Traits\GraphTrait;
use App\Models\Traits\LatestTrait;
use App\Models\Traits\PremiumTrait;
use App\Models\Traits\CoverUrlTrait;
use App\Models\Traits\TaggableTrait;
use Bow\Database\Barry\Relations\HasMany;
use App\Models\Traits\HasTechnologyTrait;
use Bow\Database\Barry\Relations\BelongsTo;

class Tutorial extends Model
{
    use CoverUrlTrait;
    use GraphTrait;
    use HasTechnologyTrait;
    use LatestTrait;
    use PremiumTrait;
    use TaggableTrait;

    /**
     * The display fields
     *
     * @var array
     */
    public const SELECT_FIELD = [
        'id', 'title', 'slug', 'request_by', 'color', 'description', 'video', 'cover',
        'technology_id', 'published_at', 'source', 'pdf', 'duration', 'level', 'repository',
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
        return $this->published == 1;
    }

    /**
     * Get all comments associates to the tutorial
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'commentable_id')
            ->where('commentable_type', Tutorial::class);
    }

    /**
     * Get the toturial author
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * Determine if the parsed slug already exists
     *
     * @param  string $slug
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
    public function progrestions(): HasMany
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
                $curriculum_id = $this->graph->section->curriculum_id;
            }
        }

        $progrestion = $this->progrestions()->where('user_id', $user->id)->first();

        if (is_null($progrestion)) {
            // Create the new progrestion
            $progrestion = $this->progrestions()->create([
                'timespent' => 0,
                'ended' => 0,
                'started_at' => app_now(),
                'user_id' => $user->id,
                'curriculum_id' => $curriculum_id,
            ]);
        }

        if ($progrestion->curriculum_id != $curriculum_id) {
            $progrestion->curriculum_id = $curriculum_id;
            $progrestion->touch();
        }

        return $progrestion;
    }

    /**
     * Determine if user have progress to
     *
     * @return bool
     */
    public function hasProgress(User $user, ?int $curriculum_id = null)
    {
        if ($curriculum_id) {
            $progrestion = $this->progrestions()->where('user_id', $user->id)->where('curriculum_id', $curriculum_id)->first();
        } else {
            $progrestion = $this->progrestions()->where('user_id', $user->id)->first();
        }

        return $progrestion?->ended ?? false;
    }

    /**
     * __mutator
     *
     * @return string
     */
    public function getDurationAttribute(string $value)
    {
        $value = (int) $value;

        return $value . ' ' . $this->duration_type;
    }
}
