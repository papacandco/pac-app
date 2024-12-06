<?php

namespace App\Models;

use App\Models\Traits\BookmarkTrait;
use App\Models\Traits\CoverUrlTrait;
use App\Models\Traits\FindByTrait;
use App\Models\Traits\HasTechnologieTrait;
use App\Models\Traits\PremiumTrait;
use Illuminate\Database\Eloquent\Builder;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculum extends Model
{
    use BookmarkTrait;
    use CoverUrlTrait;
    use FindByTrait;
    use HasTechnologieTrait;
    use PremiumTrait;
    use SoftDeletes;

    /**
     * Define the table used by model
     *
     * @var string
     */
    protected $table = 'curriculums';

    /**
     * The fillable data
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'color', 'video',
        'with_forum', 'long_description',
        'level', 'duration', 'description',
        'cover', 'technologie_id',
    ];

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
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    /**
     * Get all graphs associate to this curriculum
     *
     * @return HasManyThrough
     */
    public function graphs()
    {
        return $this->hasManyThrough(Graph::class, Section::class);
    }

    /**
     * Get all tutorials associate to this curriculum
     *
     * @return HasManyThrough
     */
    public function tutorials()
    {
        return $this->graphs()
            ->select('tutorials.*')
            ->where('graph_type', Tutorial::class)
            ->join('tutorials', ['graphs.graph_id' => 'tutorials.id'])
            ->orderBy('graphs.order', 'asc');
    }

    /**
     * Get all comments associate to this curriculum
     *
     * @return HasManyThrough
     */
    public function comments()
    {
        return $this->graphs()
            ->where('graph_type', Tutorial::class)
            ->join('comments', [
                'commentable_type' => 'graph_type',
                'commentable_id' => 'graph_id',
            ]);
    }

    /**
     * Get all likes of tutorial associate to this curriculum
     *
     * @return HasManyThrough
     */
    public function likes()
    {
        return $this->graphs()
            ->join('likes', [
                'likable_type' => 'graph_type',
                'likable_id' => 'graph_id',
            ]);
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
     * @param  string  $value
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
    public function withForum()
    {
        return $this->where('with_forum', 1);
    }

    /**
     * Get the questions
     *
     * @return HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'curriculum_id', 'id');
    }

    /**
     * Get the lastest questions
     *
     * @return mixed
     */
    public function lastQuestion($number = 5)
    {
        return $this->questions()
            ->select('id', 'title', 'user_id', 'slug', 'created_at')
            ->orderBy('created_at', 'asc')->take($number)->get();
    }

    /**
     * Get the list of progrestion
     *
     * @return HasMany
     */
    public function progrestions()
    {
        return $this->hasMany(Progrestion::class, 'curriculum_id');
    }

    /**
     * Compute the progress for user
     *
     * @return int
     */
    public function computeProgression(User $user)
    {
        $current = $this->progrestions()->where('user_id', $user->id)->whereEnded(true)->count();

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

        return $value.' '.$this->duration_type;
    }
}
