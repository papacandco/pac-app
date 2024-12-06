<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bow\Database\Barry\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'dial_code', 'currency'];
}
