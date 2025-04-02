
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
    
    $app->add(new SessionMiddleware());
    $app->add(new ViewMiddleware($container->get(BladeService::class)));
    $app->add(new LanguageMiddleware());
    $app->add(new StaticAssetsMiddleware());
    // Add as one of the last middleware in the stack
    // but before error handling middleware
    $app->add(HtmlCompressorMiddleware::class);
};
