<?php

namespace App\Providers;

use App\Services\UrlGenerator;

class PaginationProvider
{
    public static function boot()
    {
        $urlGenerator = new UrlGenerator();
        
        // Register URL generator as a singleton if needed
        // $container->set(UrlGenerator::class, $urlGenerator);
    }
}
