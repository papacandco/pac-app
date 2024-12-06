<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
    use SoftDeletes;

    /**
     * The list of fillable
     *
     * @var array
     */
    protected $fillable = ['email'];

    /**
     * Check the email exists
     *
     * @param  string  $email
     * @return bool
     */
    public static function hasEmail($email)
    {
        return static::where('email', $email)->exists();
    }
}
