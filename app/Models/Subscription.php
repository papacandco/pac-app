<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The fillable data
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'product_id',
        'next_product_id',
        'ended_at',
        'grace_time_ended_at',
        'user_id',
        'extras',
    ];

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
    protected $dates = ['ended_at', 'grace_time_ended_at'];

    /**
     * Define the primary key type
     *
     * @var bool
     */
    protected $keyType = 'string';
}
