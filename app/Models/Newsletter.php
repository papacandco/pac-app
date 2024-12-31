<?php

namespace App\Models;

use Bow\Database\Barry\Model;

class Newsletter extends Model
{
    /**
     * Check the email exists
     *
     * @param  string $email
     * @return bool
     */
    public static function hasEmail($email)
    {
        return static::where('email', $email)->exists();
    }
}
