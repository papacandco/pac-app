<?php

use App\Models\Author;
use Faker\Factory;

$faker = Factory::create();

$authors = [];

$authors[] = [
    'name' => $faker->name,
    'pseudo' => 'papac',
    'email' => 'dakiafranck@gmail.com',
    'description' => $faker->text(50),
];

return [Author::class => $authors];
