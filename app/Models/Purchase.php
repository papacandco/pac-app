<?php

namespace App\Models;

use Bow\Database\Barry\Model;
use Bow\Database\Barry\Relations\BelongsTo;

class Purchase extends Model
{
    /**
     * Get the purchaseable instance
     *
     * @return mixed
     */
    public function purchaseable(): BelongsTo
    {
        return $this->belongsTo($this->purchaseable_type, 'purchaseable_id')
            ->where('purchaseable_type', $this->purchaseable_type);
    }
}
