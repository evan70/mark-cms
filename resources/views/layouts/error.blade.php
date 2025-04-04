<!DOCTYPE html>
<html lang="{{ $language ?? config('app.default_language', 'sk') }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Error' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">

    <link href="/css/app.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-900 text-gray-100 flex flex-col">
    <!-- Navigation -->
    <header class="bg-gray-900 border-b border-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-white">
                        {{ config('app.name', 'Mark CMS') }}
                    </a>
                </div>

                <nav class="hidden md:flex space-x-6">
                    <a href="/" class="text-gray-300 hover:text-white transition-colors">Home</a>
                    <a href="/{{ $language ?? config('app.default_language', 'sk') }}/about" class="text-gray-300 hover:text-white transition-colors">About</a>
                    <a href="/{{ $language ?? config('app.default_language', 'sk') }}/services" class="text-gray-300 hover:text-white transition-colors">Services</a>
                    <a href="/{{ $language ?? config('app.default_language', 'sk') }}/contact" class="text-gray-300 hover:text-white transition-colors">Contact</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <x-language-switcher />
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="flex-grow">
        @yield('content')

        <!-- Search Form -->
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-md mx-auto">
                <h2 class="text-xl font-semibold mb-4 text-center">Looking for something?</h2>
                <form action="/{{ $language ?? config('app.default_language', 'sk') }}/search" method="GET" class="w-full">
                    <div class="flex">
                        <input type="text"
                               name="q"
                               value=""
                               placeholder="Search in content..."
                               class="flex-grow px-4 py-2 rounded-l-md bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="submit"
                                class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-400">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Mark CMS') }}. All rights reserved.
                    </p>
                </div>

                <div class="flex space-x-6">
                    <a href="/{{ $language ?? config('app.default_language', 'sk') }}/privacy" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="/{{ $language ?? config('app.default_language', 'sk') }}/terms" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
