<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Builder;
use App\Models\Traits\PremiumTrait;
use App\Models\Traits\BookmarkTrait;
use App\Models\Traits\CoverUrlTrait;
use Bow\Database\Barry\Relations\HasMany;
use App\Models\Traits\HasTechnologyTrait;
use Bow\Database\Collection;

class Curriculum extends Model
{
    use BookmarkTrait;
    use CoverUrlTrait;
    use HasTechnologyTrait;
    use PremiumTrait;

    /**
     * Define the table used by model
     *
     * @var string
     */
    protected string $table = 'curriculums';

    /**
     * The level of curriculum
     *
     * @var array
     */
    public const LEVEL = [
        1 => 'Débutant',
        2 => 'Intermédiaire',
        3 => 'Avancé',
    ];

    /**
     * Curriculum constructor
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Curriculum::deleting(function (Curriculum $curriculum) {
            $curriculum->slug = sprintf('%s_%s', time(), $curriculum->slug);
            $curriculum->save();
            @Material::wherePath($curriculum->cover)->delete();
        });
    }

    /**
     * Get all sections associates to the curriculum
     *
     * @return HasMany
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'curriculum_id');
    }

    /**
     * Get all graphs associate to this curriculum
     *
     * @return mixed
     */
    public function graphs()
    {
        return $this->hasMany(Graph::class, 'sections.curriculum_id')
            ->select(['graphs.*'])
            ->join("sections", 'sections.id', 'graphs.section_id')
            ->orderBy('graphs.order', 'asc');
    }

    /**
     * Get all tutorials associate to this curriculum
     *
     * @return mixed
     */
    public function tutorials()
    {
        return $this->hasMany(Tutorial::class, 'sections.curriculum_id')
            ->select(['tutorials.*'])
            ->join("graphs", 'graphs.graph_id', 'tutorials.id')
            ->join("sections", 'graphs.section_id', 'sections.id')
            ->join("curriculums", 'sections.curriculum_id', 'curriculums.id')
            ->where('graph_type', Tutorial::class);
    }

    /**
     * Get all comments associate to this curriculum
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->graphs()
            ->where('graph_type', Tutorial::class)
            ->join('comments',  ['commentable_type' => 'graph_type', 'commentable_id' => 'graph_id']);
    }

    /**
     * Get the level to human begin understand
     *
     * @return string
     */
    public function levelForHuman()
    {
        return static::LEVEL[$this->level] ?? 'Aucun';
    }

    /**
     * __mutator
     *
     * @param  string $value
     * @return string
     */
    public function getLongDescriptionAttribute($value)
    {
        return trim($value);
    }

    /**
     * Load the query forum technologie associate with forum
     *
     * @return Builder
     */
    public function withForum(): Builder
    {
        return $this->where('with_forum', 1);
    }

    /**
     * Get the questions
     *
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'curriculum_id', 'id');
    }

    /**
     * Get the lastest questions
     *
     * @return Collection
     */
    public function lastQuestion($number = 5): Collection
    {
        return $this->questions()
            ->select(['id', 'title', 'user_id', 'slug', 'created_at'])
            ->orderBy('created_at', 'asc')->take($number)->get();
    }

    /**
     * Get the list of progrestion
     *
     * @return HasMany
     */
    public function progrestions(): HasMany
    {
        return $this->hasMany(Progrestion::class, 'curriculum_id');
    }

    /**
     * Compute the progress for user
     *
     * @return float|int
     */
    public function computeProgression(User $user): float|int
    {
        $current = $this->progrestions()->where('user_id', $user->id)->where('ended', true)->count();

        $global = $this->tutorials()->count();

        if ($global == 0) {
            return 0;
        }

        return ceil($current * 100 / $global);
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
