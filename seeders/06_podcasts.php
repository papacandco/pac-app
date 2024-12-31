<?php

use App\Models\Author;
use App\Models\Podcast;
use Faker\Factory;

$faker = Factory::create();

$padcast = [
    'title' => $faker->text(10),
    'description' => $faker->text(50),
    'cover' => '/img/cover.jpg',
    'status' => 1,
    'source' => 'podcasts/1.mp3',
    'author_id' => 1,
    'content' => $faker->text(500),
    'published' => true,
    'published_at' => now(),
];

return [Podcast::class => $padcast];
