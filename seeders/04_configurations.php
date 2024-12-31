<?php

use App\Models\Configuration;

$configuration = [
    'name' => 'Papac & Co',
    'username' => 'Papac',
    'email' => 'admin@papacandco.com',
    'password' => app_hash('password'),
    'about_video' => 'https://www.youtube.com/embed/R8gKs4jp7RU',
];

return [Configuration::class => $configuration];
