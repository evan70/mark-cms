<?php

namespace App\Services;

class UrlGenerator
{
    public function to($path, $extra = [], $secure = null)
    {
        return $path;
    }

    public function secure($path, $parameters = [])
    {
        return $this->to($path, $parameters, true);
    }

    public function asset($path, $secure = null)
    {
        return $this->to($path, [], $secure);
    }

    public function route($name, $parameters = [], $absolute = true)
    {
        return $this->to($name, $parameters);
    }

    public function current()
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function previous($fallback = false)
    {
        return $_SERVER['HTTP_REFERER'] ?? '/';
    }
}
