<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Builder;
use App\Models\Traits\CoverUrlTrait;

class Annonce extends Model
{
    use CoverUrlTrait;

    /**
     * The list of available annonce
     *
     * @var array
     */
    public const ANNONCE = [
        1 => 'New',
        2 => 'Job',
        3 => 'Ads',
    ];

    public const ANNONCE_NEW = '1';

    public const ANNONCE_JOB = '2';

    public const ANNONCE_ADS = '3';

    /**
     * Date mutator
     *
     * @var array
     */
    protected $dates = ['started_at', 'ended_at'];

    /**
     * Annonce constructor
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        Annonce::deleted(function (Annonce $annonce) {
            @Material::wherePath($annonce->cover)->delete();
        });
    }

    /**
     * Get online annonce
     *
     * @return Builder
     */
    public function scopeOnline(Builder $query)
    {
        return $query->where('online', 1);
    }

    /**
     * Push online
     *
     * @return mixed
     */
    public function turnOnline()
    {
        $this->online = true;

        return $this->touch();
    }

    /**
     * Push online
     *
     * @return mixed
     */
    public function turnOffline()
    {
        $this->online = false;

        return $this->touch();
    }

    /**
     * Check if this annonce is online
     *
     * @return bool
     */
    public function isOnline()
    {
        return $this->online == 1;
    }

    /**
     * Update click counter
     *
     * @return bool
     */
    public function click()
    {
        $this->click = $this->click + 1;

        return $this->save();
    }

    /**
     * Get type of annonce by Name
     *
     * @param  string  $value
     * @return mixed
     */
    public function getTypeNameAttribute($value)
    {
        return static::ANNONCE[$this->type] ?? 'N/A';
    }

    /**
     * Check if annonce is ads
     *
     * @return bool
     */
    public function isAds()
    {
        return Annonce::ANNONCE[$this->type] == 'Ads';
    }

    /**
     * Check if annonce is ads
     *
     * @return bool
     */
    public function isJob()
    {
        return Annonce::ANNONCE[$this->type] == 'Job';
    }

    /**
     * Check if annonce is ads
     *
     * @return bool
     */
    public function isNew()
    {
        return Annonce::ANNONCE[$this->type] == 'New';
    }
}
