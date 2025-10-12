<?php

if (!function_exists('app')) {
    function app()
    {
        global $app;
        return $app;
    }
}

if (!function_exists('url')) {
    /**
     * Generate a URL for the application.
     *
     * @param string $path
     * @param array $params
     * @return string
     */
    function url(string $path = '', array $params = []): string
    {
        // Get the current URL scheme and host
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';

        // Use current URL as base URL if available, otherwise fall back to APP_URL
        $baseUrl = $scheme . '://' . $host;

        // Fall back to APP_URL if we couldn't determine the current URL
        if ($baseUrl === 'http://localhost') {
            $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/');
        }

        $path = ltrim($path, '/');

        $url = $baseUrl . '/' . $path;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}

if (!function_exists('request')) {
    /**
     * Get the current request object.
     *
     * @return object
     */
    function request(): object
    {
        return new class {
            /**
             * Check if the current request path matches a pattern.
             *
             * @param string $pattern
             * @return bool
             */
            public function is(string $pattern): bool
            {
                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                $path = trim($path, '/');

                // Convert the pattern to a regular expression
                $pattern = preg_quote($pattern, '#');
                $pattern = str_replace('\*', '.*', $pattern);

                return (bool) preg_match('#^' . $pattern . '$#i', $path);
            }

            /**
             * Get the path info of the current request.
             *
             * @return string
             */
            public function getPathInfo(): string
            {
                return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
            }
        };
    }
}

if (!function_exists('now')) {
    /**
     * Get the current date and time.
     *
     * @return string
     */
    function now(): string
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('csrf_fields')) {
    /**
     * Generate CSRF fields for forms
     *
     * @return string HTML for CSRF fields
     */
    function csrf_fields(): string
    {
        $csrf = app()->getContainer()->get('csrf');
        $nameKey = $csrf->getTokenNameKey();
        $valueKey = $csrf->getTokenValueKey();

        // Get existing token or create a new one
        $name = $csrf->getTokenName() ?? '';
        $value = $csrf->getTokenValue() ?? '';

        return sprintf(
            '<input type="hidden" name="%s" value="%s">' .
            '<input type="hidden" name="%s" value="%s">',
            $nameKey,
            $name,
            $valueKey,
            $value
        );
    }
}

if (!function_exists('config')) {
    function config($key, $default = null) {
        $parts = explode('.', $key);
        $filename = array_shift($parts);

        static $config = [];

        if (!isset($config[$filename])) {
            $path = __DIR__ . '/../config/' . $filename . '.php';
            $config[$filename] = file_exists($path) ? require $path : [];
        }

        $current = $config[$filename];

        foreach ($parts as $part) {
            if (!is_array($current) || !isset($current[$part])) {
                return $default;
            }
            $current = $current[$part];
        }

        return $current;
    }
}

if (!function_exists('asset')) {
    function asset($path) {
        try {
            return mix($path);
        } catch (Exception $e) {
            // Check if the path starts with 'images/'
            if (strpos($path, 'images/') === 0) {
                return '/' . ltrim($path, '/');
            }
            return '/assets/' . ltrim($path, '/');
        }
    }
}

if (!function_exists('__')) {
    function __($key) {
        // Simple translation function - you might want to implement proper translation later
        return $key;
    }
}

if (!function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string|array|null
     */
    function trans($key = null, $replace = [], $locale = null)
    {
        return __($key, $replace, $locale);
    }
}

if (!function_exists('request')) {
    function request()
    {
        return (object) [
            'query' => function () {
                return $_GET;
            },
            'getPathInfo' => function () {
                return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
            }
        ];
    }
}

if (!function_exists('session')) {
    function session($key = null, $default = null)
    {
        $session = app()->getContainer()->get('session');

        if (is_null($key)) {
            return $session;
        }

        if (func_num_args() === 1) {
            return $session->get($key, $default);
        }

        $session->set($key, $default);
        return null;
    }
}

if (!function_exists('flash')) {
    function flash($key = null, $message = null)
    {
        $session = session();

        if (is_null($key)) {
            return $session->getFlashMessages();
        }

        if (!is_null($message)) {
            $session->flash($key, $message);
            return null;
        }

        return $session->getFlash($key);
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        return $_SESSION['csrf_token'] ?? '';
    }
}

if (!function_exists('mix')) {
    function mix($path) {
        static $manifest;

        if (!$manifest) {
            $manifestPath = dirname(__DIR__) . '/public/mix-manifest.json';

            if (!file_exists($manifestPath)) {
                throw new Exception('The Mix manifest does not exist.');
            }

            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        $path = "/{$path}";

        if (!isset($manifest[$path])) {
            throw new Exception("Unable to locate Mix file: {$path}.");
        }

        return $manifest[$path];
    }
}

if (!function_exists('starts_with')) {
    function starts_with($haystack, $needle)
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('view')) {
    function view($view, $data = [])
    {
        global $app;
        $blade = $app->getContainer()->get('view');
        return $blade->render($view, $data);
    }
}

if (!function_exists('str_limit')) {
    function str_limit($value, $limit = 100, $end = '...')
    {
        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $limit)) . $end;
    }
}

if (!function_exists('markdown')) {
    function markdown($text)
    {
        $parser = new \Parsedown();
        return $parser->text($text);
    }
}

if (!function_exists('article_link')) {
    /**
     * Generate a properly formatted link to an article
     *
     * @param \App\Models\Article $article The article to link to
     * @param string $language The current language code
     * @param array $options Additional options for the link
     * @return string HTML for the link
     */
    function article_link($article, $language, $options = [])
    {
        $service = app()->getContainer()->get(\App\Services\ArticleLinkService::class);
        return $service->renderArticleLink($article, $language, $options);
    }
}

if (!function_exists('get_language_prefix')) {
    /**
     * Get the language prefix for URLs
     *
     * @param string $language The language code
     * @return string The prefix (empty for default language)
     */
    function get_language_prefix($language)
    {
        $defaultLanguage = $_ENV['DEFAULT_LANGUAGE'] ?? 'sk';
        return $language === $defaultLanguage ? '' : '/' . $language;
    }
}


