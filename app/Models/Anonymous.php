<?php

namespace App\Models;

use App\Models\Traits\TrackableTrait;
use Bow\Database\Barry\Model;
use Illuminate\Notifications\Notifiable;

class Anonymous extends Model
{
    use TrackableTrait;
}
