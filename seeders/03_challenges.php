<?php

use App\Models\Challenge;
use Faker\Factory;

$faker = Factory::create();

$challenges = [];

foreach (range(1, 3) as $key => $value) {
    $challenges[] = [
        'title' => $faker->text(30),
        'description' => $faker->text,
        'video' => 'https://www.youtube.com/embed/R8gKs4jp7RU',
        'diffused_at' => app_now()->addMinute(),
        'technology_id' => [1, 2, 3][rand(0, 2)],
        'author_id' => 1,
    ];
}

return [Challenge::class => $challenges];
