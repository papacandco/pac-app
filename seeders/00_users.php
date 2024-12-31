<?php

use Faker\Factory;
use App\Models\User;

$faker = Factory::create();

$users = [];

foreach (range(1, 2) as $key) {
    $users[] = [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'sexe' => ['man', 'woman'][rand(0, 1)],
        'email_verified_at' => now(),
        'password' => app_hash('secret'),
        'pseudo' => uniqid(),
    ];
}

return [User::class => $users];
