<?php

namespace App\Controllers\Traits;

use App\Models\Technology;
use Bow\Database\Barry\Model;

trait ForumTrait
{
    /**
     * Get the forum associate
     *
     * @return Technology|null
     */
    protected function forum(string $slug, Model $model)
    {
        return $model->withForum()
            ->where('slug', $slug)->first();
    }
}
