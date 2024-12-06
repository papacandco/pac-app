<?php

namespace App\Controllers\Traits;

use App\Models\Technologie;
use Bow\Database\Barry\Model;

trait ForumTrait
{
    /**
     * Get the forum associate
     *
     * @return Technologie|null
     */
    protected function forum(string $slug, Model $model)
    {
        return $model->withForum()
            ->where('slug', $slug)->firstOrFail();
    }
}
