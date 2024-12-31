<?php

use App\Models\Annonce;
use Faker\Factory;

$faker = Factory::create();

$annonces = [];

$annonces[] = [
    'type' => 1,
    'message' => $faker->text(20),
    'link' => gravatar($faker->email),
    'online' => 0,
    'started_at' => now()->addDay(1),
    'ended_at' => now()->addDay(2),
    'created_at' => now(),
];

return [Annonce::class => $annonces];
