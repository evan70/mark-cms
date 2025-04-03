
<?php

use App\Middleware\HtmlCompressorMiddleware;
use App\Middleware\ViewMiddleware;
use App\Middleware\LanguageMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\StaticAssetsMiddleware;
use App\Services\BladeService;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    // Add middleware in reverse order (last added = first executed)
    $app->add(new ViewMiddleware($container->get(BladeService::class)));
    $app->add(new LanguageMiddleware());
    $app->add(new StaticAssetsMiddleware());
    // Session middleware must be added before CSRF middleware
    // because CSRF middleware uses session
    $app->add(new SessionMiddleware());
    $app->add($container->get(\App\Middleware\SkipCsrfMiddleware::class));
    $app->add($container->get('csrf'));
    // Add as one of the last middleware in the stack
    // but before error handling middleware
    $app->add(HtmlCompressorMiddleware::class);
};
