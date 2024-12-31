<?php

use App\Models\Technology;
use Faker\Factory;

$faker = Factory::create();

return [
    Technology::class => [
        'title' => $faker->title,
        'slug' => $faker->slug,
        'color' => '#ccc',
        'description' => $faker->text,
        'with_forum' => 1,
        'cover' => 'https://via.placeholder.com/150',
    ]
];
