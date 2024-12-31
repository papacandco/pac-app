<?php

namespace App\Models;

use Bow\Database\Barry\Model;

class Subscription extends Model
{
    /**
     * Hidden field
     *
     * @var array
     */
    protected array $hidden = ['published_at', 'updated_at', 'created_at'];

    /**
     * The mutation data
     *
     * @var array
     */
    protected array $dates = ['ended_at', 'grace_time_ended_at'];

    /**
     * Define the primary key type
     *
     * @var bool
     */
    protected $primary_type = 'string';
}
