<?php

namespace App\Models\Traits;

use App\Models\Graph;
use Bow\Database\Barry\Relations\BelongsTo;

trait GraphTrait
{
    /**
     * Get the graph
     *
     * @return BelongsTo
     */
    public function graph()
    {
        return $this->belongsTo(Graph::class);
    }
}
