<?php

return [
    'name' => env('APP_NAME', 'responsive.sk'),

    'description' => env('APP_DESCRIPTION', 'Moderné webové a mobilné riešenia s dôrazom na výkon a používateľský zážitok. Špecializujeme sa na vývoj digitálnych produktov budúcnosti.'),

    'meta_keywords' => env('APP_META_KEYWORDS', 'web development, mobile development, digital solutions, responsive design, web applications'),

    'available_languages' => ['sk', 'cs', 'en'],

    'default_language' => env('DEFAULT_LANGUAGE', 'sk'),

    'env' => $_ENV['APP_ENV'] ?? 'production',

    'debug' => (bool)($_ENV['APP_DEBUG'] ?? false),

    'url' => $_ENV['APP_URL'] ?? 'http://localhost',

    'timezone' => 'UTC',

    'locale' => 'sk',

    'fallback_locale' => 'en',

    'supported_locales' => ['en', 'sk'],
];
