<?php

namespace App\Models;

use Bow\Auth\Authentication;
use Bow\Database\Barry\Model;
use App\Models\Traits\LatestTrait;
use App\Models\Traits\PremiumTrait;
use App\Models\Traits\BookmarkTrait;
use Bow\Database\Barry\Relations\HasMany;
use Bow\Messaging\CanSendMessaging;
use Bow\Support\Collection;

class User extends Authentication
{
    use BookmarkTrait;
    use LatestTrait;
    use PremiumTrait;
    use CanSendMessaging;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected array $hidden = [
        'password', 'remember_token', 'email_verified_at', 'deleted_at', 'logged_at', 'provider_type', 'provider_id',
    ];

    /**
     * Cost the column to date
     *
     * @var array
     */
    protected array $dates = ['logged_at'];

    /**
     * User constructor
     *
     * @return mixed
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        User::deleting(fn ($user) => $user->comments()->delete());
    }

    public function sendWelcomeMessage()
    {
        // Send mail message
    }

    public function unreadMessages(): Collection
    {
        return new Collection([]);
    }

    /**
     * Get all user comments
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * Get user question
     *
     * @return HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'user_id');
    }

    /**
     * Get all bookmarks
     *
     * @return HasMany
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'user_id');
    }

    /**
     * Get all purchases
     *
     * @return HasMany
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id');
    }

    /**
     * Check if element have been purchased
     *
     * @param  Model $purchaseable
     * @return bool
     */
    public function hasPurchased($purchaseable)
    {
        return $this->purchases()
            ->wherePurchaseableId($purchaseable->id)
            ->wherePurchaseableType(get_class($purchaseable))
            ->exists();
    }

    /**
     * Create the new bookmark for purchase
     *
     * @return mixed
     */
    public function purchase($element)
    {
        if ($this->hasPurchased($element)) {
            return false;
        }

        $this->mark($element);

        return Purchase::create([
            'user_id' => $this->id,
            'price' => $element->price,
            'fee' => $element->provider_exstra['free'] ?? 0,
            'purchaseable_id' => $element->id,
            'purchaseable_type' => get_class($element),
            'extras' => json_encode($element),
        ]);
    }

    /**
     * Change user status
     *
     * @return void
     */
    public function subscribe(Product $product)
    {
        $ended_at = $product->interval == 'month' ? now()->addMonth()->addDay() : now()->addYear()->addDay();

        $ended_at = match ($this->interval) {
            'month' => now()->addMonth()->addDay(),
            'year' => now()->addYear()->addDay(),
            'forever' => now()->addYears(120),
        };

        $this->subscriptions()->create([
            'id' => str_uuid(),
            'product_id' => $product->product_id,
            'next_product_id' => $product->product_id,
            'ended_at' => $ended_at,
            'grace_time_ended_at' => $ended_at->addDays(6),
            'extras' => json_encode($product),
        ]);

        $this->premium = true;
        $this->timestamps = false;
        $this->save();
    }

    /**
     * Change user status
     *
     * @return bool
     */
    public function hasSubscribe(Product $product)
    {
        $subsciption = $this->subscriptions()
            ->where("product_id", $product->product_id)
            ->orderBy('ended_at', 'desc')->first();

        if (is_null($subsciption)) {
            return false;
        }

        if ($subsciption->ended_at->isPast()) {
            return false;
        }

        if ($subsciption->grace_time_ended_at->isPast()) {
            return false;
        }

        if ($subsciption->next_product_id !== $product->product_id) {
            return false;
        }

        return true;
    }

    /**
     * Change user status
     *
     * @return void
     */
    public function unsubscribe()
    {
        $this->premium = false;
        $this->timestamps = false;

        $this->save();
    }

    /**
     * Get all subscriptions
     *
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    /**
     * Get all transactions
     *
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Get all bookmarks
     *
     * @return array
     */
    public function tutorialBookmarks()
    {
        $tutorials = [];

        $results = $this->hasMany(Bookmark::class, 'user_id')
            ->select(['tutorials.*', 'bookmarks.created_at as bookmarked_at'])
            ->where('bookmarkable_type', Tutorial::class)
            ->orderBy('bookmarked_at', 'desc')
            ->join('tutorials', 'bookmarkable_id', 'tutorials.id')->get();

        foreach ($results as $result) {
            $tutorial = new Tutorial($result->toArray());
            $tutorial->id = $result->id;
            $tutorials[] = $tutorial;
        }

        return $tutorials;
    }

    /**
     * Get all bookmarks
     *
     * @return array
     */
    public function curriculumBookmarks()
    {
        $curriculums = [];

        $results = $this->hasMany(Bookmark::class, 'user_id')
            ->select(['curriculums.*', 'bookmarks.created_at as bookmarked_at'])
            ->where('bookmarkable_type', Curriculum::class)
            ->orderBy('bookmarked_at', 'desc')
            ->join('curriculums', 'bookmarkable_id', 'curriculums.id')->get();

        foreach ($results as $result) {
            $curriculum = new Curriculum($result->toArray());
            $curriculum->created_at = $result->created_at;
            $curriculum->updated_at = $result->updated_at;
            $curriculum->id = $result->id;
            $curriculums[] = $curriculum;
        }

        return $curriculums;
    }

    /**
     * Get all bookmarks
     *
     * @return array
     */
    public function questionBookmarks()
    {
        $questions = [];

        $results = $this->hasMany(Bookmark::class, 'bookmarks.user_id')
            ->select(['questions.*', 'bookmarks.created_at as bookmarked_at'])
            ->where('bookmarkable_type', Question::class)
            ->join('questions', 'bookmarkable_id', 'questions.id')->get();

        foreach ($results as $result) {
            $question = new Question($result->toArray());
            $question->id = $result->id;
            $question->created_at = $result->created_at;
            $question->updated_at = $result->updated_at;
            $questions[] = $question;
        }

        return $questions;
    }

    /**
     * Get all bookmarks
     *
     * @return array
     */
    public function podcastBookmarks()
    {
        $podcasts = [];

        $results = $this->hasMany(Bookmark::class, 'user_id')
            ->select(['podcasts.*', 'bookmarks.created_at as bookmarked_at'])
            ->where('bookmarkable_type', Podcast::class)
            ->join('podcasts', 'bookmarkable_id', 'podcasts.id')->get();

        foreach ($results as $result) {
            $podcast = new Question($result->toArray());
            $podcast->id = $result->id;
            $podcasts[] = $podcast;
        }

        return $podcasts;
    }

    /**
     * Get all bookmarks
     *
     * @return $bookmarkable
     * @return bool
     */
    public function hasBookmark($bookmarkable)
    {
        return $this->hasMany(Bookmark::class, 'user_id')
            ->where('bookmarkable_type', get_class($bookmarkable))
            ->exists();
    }

    /**
     * Get the list of progrestion
     *
     * @return HasMany
     */
    public function progrestions()
    {
        return $this->hasMany(Progrestion::class, 'user_id');
    }

    /**
     * Determine if user have progress to
     *
     * @return Progrestion
     */
    public function progrestion(Tutorial $tutorial)
    {
        return $this->progrestions()
            ->whereProgressableId($tutorial->id)
            ->whereProgressableType(get_class($tutorial))
            ->first();
    }

    /**
     * Determine if user have progress to
     *
     * @return bool
     */
    public function hasProgress(Tutorial $tutorial)
    {
        $progrestion = $this->progrestion($tutorial);

        return ! is_null($progrestion) && $progrestion->ended;
    }

    /**
     * Get the avatar image
     *
     * @param  string $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if (is_null($value)) {
            $value = gravatar($this->email);
        }

        return $value;
    }
}
