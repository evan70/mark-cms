<?php

namespace App\Services;

use DI\Container;
use Illuminate\Contracts\Container\Container as IlluminateContainer;

class IlluminateContainerAdapter implements IlluminateContainer
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function bound($abstract)
    {
        return $this->container->has($abstract);
    }

    public function alias($abstract, $alias)
    {
        // Not implemented
    }

    public function tag($abstracts, $tags)
    {
        // Not implemented
    }

    public function tagged($tag)
    {
        // Not implemented
    }

    public function bind($abstract, $concrete = null, $shared = false)
    {
        // Not implemented
    }

    public function singleton($abstract, $concrete = null)
    {
        // Not implemented
    }

    public function extend($abstract, \Closure $closure)
    {
        // Not implemented
    }

    public function instance($abstract, $instance)
    {
        // Not implemented
    }

    public function when($concrete)
    {
        // Not implemented
    }

    public function make($abstract, array $parameters = [])
    {
        return $this->container->get($abstract);
    }

    public function resolved($abstract)
    {
        return true;
    }

    public function resolving($abstract, \Closure $callback = null)
    {
        // Not implemented
    }

    public function afterResolving($abstract, \Closure $callback = null)
    {
        // Not implemented
    }
}