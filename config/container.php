<?php

use App\Services\BladeService;
use DI\Container;
use Psr\Container\ContainerInterface;

return [
    'settings' => function() {
        return require __DIR__ . '/settings.php';
    },

    BladeService::class => function (ContainerInterface $container) {
        $settings = $container->get('settings');

        $viewPath = $settings['view']['template_path'] ?? __DIR__ . '/../resources/views';
        $cachePath = $settings['view']['cache_path'] ?? __DIR__ . '/../storage/cache/views';

        // Ensure cache directory exists
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        return new BladeService($viewPath, $cachePath);
    },

    'view' => function (ContainerInterface $container) {
        return $container->get(BladeService::class);
    },

    \App\Services\ArticleLinkService::class => function (ContainerInterface $container) {
        return new \App\Services\ArticleLinkService();
    },
];
