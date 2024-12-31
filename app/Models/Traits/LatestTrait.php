<?php

namespace App\Models\Traits;

use App\Models\Tutorial;

trait LatestTrait
{
    /**
     * Get last publication
     *
     * @param  int $limit
     * @return mixed
     */
    public function latestPublication($limit = 6, $order_by = 'created_at')
    {
        $query = $this->take($limit)
            ->orderBy($order_by, 'desc');

        if (get_class($this) == Tutorial::class) {
            $query
                ->select(Tutorial::SELECT_FIELD)
                ->where('published', true)
                ->whereNull('graph_id');
        }

        return $query->get();
    }
}
