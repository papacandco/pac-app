<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /**
     * Hidden field
     *
     * @var array
     */
    protected $hidden = ['published_at', 'updated_at', 'created_at'];

    /**
     * The mutation data
     *
     * @var array
     */
    protected array $dates = ['published_at'];

    /**
     * __mutator for the options attribute
     *
     * @var string
     */
    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get the interval as humain
     *
     * @return string
     */
    public function getIntervalAsHuman()
    {
        return match ($this->interval) {
            'month' => '/Mois',
            'year' => '/An',
            'forever' => ' à vie',
        };
    }
}
