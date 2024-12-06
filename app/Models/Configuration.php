<?php

namespace App\Models;

use Bow\Database\Barry\Model;

class Configuration extends Model
{
    /**
     * The fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'mode', 'about_video',
    ];

    /**
     * The primary key
     *
     * @var string
     */
    protected $primaryKey = 'email';

    /**
     * Primary key type
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Check if alert system is activied
     *
     * @return bool
     */
    public function hasAlert()
    {
        return $this->alert == 1;
    }
}
