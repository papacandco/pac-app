<?php

use App\Models\Curriculum;
use Faker\Factory;

$faker = Factory::create();

$curriculum = [
    'title' => $faker->title,
    'slug' => $faker->slug,
    'color' => '#ccc',
    'duration' => '30 Heures',
    'level' => 1,
    'technology_id' => [1, 2, 3][rand(0, 2)],
    'description' => $faker->text,
    'long_description' => $faker->text(500),
    'cover' => '/img/cover.jpg',
    'with_forum' => 1,
    'video' => 'https://www.youtube.com/embed/HzZxcfVn_08',
];

return [Curriculum::class => $curriculum];
