<?php


use App\Models\Taggable;
use App\Models\Tutorial;

return [
    Taggable::class => [
        'tag_id' => 1,
        'taggable_id' => 1,
        'taggable_type' => Tutorial::class,
    ]
];
