<?php

namespace App\Services;

use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class BladeService
{
    private Factory $factory;
    private string $cachePath;

    public function __construct(string $viewPath, string $cachePath)
    {
        $this->cachePath = $cachePath;

        $filesystem = new Filesystem;
        $container = new Container;

        // Configure View Factory
        $viewFinder = new FileViewFinder($filesystem, [$viewPath]);

        // Configure Blade Engine
        $resolver = new EngineResolver;
        $compiler = new BladeCompiler($filesystem, $cachePath);

        // In development mode, force clear the view cache
        if (isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'development') {
            $compiler->forceRecompile();
        }

        $resolver->register('blade', function () use ($compiler) {
            return new CompilerEngine($compiler);
        });

        // Create View Factory
        $this->factory = new Factory(
            $resolver,
            $viewFinder,
            new Dispatcher($container)
        );
    }

    public function render(string $view, array $data = []): string
    {
        return $this->factory->make($view, $data)->render();
    }

    public function share(string $key, $value): void
    {
        $this->factory->share($key, $value);
    }

    /**
     * Clear the view cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        $filesystem = new Filesystem;
        $files = $filesystem->glob($this->cachePath . '/*');

        foreach ($files as $file) {
            if ($filesystem->isFile($file)) {
                $filesystem->delete($file);
            }
        }
    }
}
