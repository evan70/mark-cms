<?php

namespace App\Providers;

use DI\Container;
use App\Services\BladeService;

class ViewProvider
{
    public static function boot(Container $container): void
    {
        $viewPaths = __DIR__ . '/../../resources/views';
        $cachePath = __DIR__ . '/../../storage/cache/views';

        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        $bladeService = new BladeService($viewPaths, $cachePath);
        $container->set('view', $bladeService);
    }
}
