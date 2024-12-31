<?php

use App\Models\Section;
use Faker\Factory;

$faker = Factory::create();

return [
    Section::class => [
        'title' => $faker->text(20),
        'description' => $faker->text(250),
        'order' => 1,
    ]
];
