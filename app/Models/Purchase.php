<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'price',
        'fee',
        'purchaseable_id',
        'purchaseable_type',
        'extras',
    ];

    /**
     * Get the purchaseable instance
     *
     * @return MorphTo
     */
    public function purchaseable()
    {
        return $this->morphTo();
    }
}
