<?php

namespace App\Controllers\Traits;

use Bow\Database\Barry\Model;

trait TaggableTrait
{
    /**
     * Create the tag information
     *
     * @param  Tutorial  $tutorial
     * @return void
     */
    protected function createTags(Model $model, array $tags)
    {
        // Create the not exists tags
        foreach ($tags as $slug) {
            $tag = $model->taggables()->where('tag_id', $slug)->first();

            if (is_null($tag)) {
                $model->taggables()->create(['tag_id' => $slug]);
            }
        }
    }
}
