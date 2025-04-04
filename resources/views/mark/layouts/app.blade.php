<!DOCTYPE html>
<html lang="en" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mark CMS' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">

    <link href="/css/app.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-900 text-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <nav class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="/mark/to-website" class="text-xl font-bold hover:text-purple-400" title="Go to website">Mark CMS</a>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="/mark/to-website" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Website</a>
                                <a href="/mark" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Dashboard</a>

                                <!-- Content Management -->
                                <a href="/mark/content" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark/content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Content</a>
                                <a href="/mark/categories" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark/categories*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Categories</a>
                                <a href="/mark/tags" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark/tags*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Tags</a>
                                <a href="/mark/media" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark/media*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Media</a>
                                <a href="/mark/ai-content" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark/ai-content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">AI Content</a>

                                <!-- User Management -->
                                <a href="/mark/users" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark/users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Users</a>
                                <a href="/mark/mark-users" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->is('mark/mark-users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Mark Users</a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="ml-3 relative" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-500">
                                            <span class="text-sm font-medium leading-none text-white">A</span>
                                        </span>
                                    </button>
                                </div>
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="/mark/profile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Your Profile</a>
                                    <a href="/mark/settings" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Settings</a>
                                    <a href="{{ url('/mark/logout') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <button type="button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="/mark/to-website" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Go to Website</a>
                    <a href="/mark" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Dashboard</a>

                    <!-- Content Management -->
                    <a href="/mark/content" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark/content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Content</a>
                    <a href="/mark/categories" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark/categories*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Categories</a>
                    <a href="/mark/tags" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark/tags*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Tags</a>
                    <a href="/mark/media" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark/media*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Media</a>
                    <a href="/mark/ai-content" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark/ai-content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">AI Content</a>

                    <!-- User Management -->
                    <a href="/mark/users" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark/users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Users</a>
                    <a href="/mark/mark-users" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('mark/mark-users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">Mark Users</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500">
                                <span class="text-sm font-medium leading-none text-white">A</span>
                            </span>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">Admin User</div>
                            <div class="text-sm font-medium leading-none text-gray-400">admin@example.com</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="/mark/profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Your Profile</a>
                        <a href="/mark/settings" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Settings</a>
                        <form method="POST" action="/mark/logout">
                            {!! csrf_fields() !!}
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 border-t border-gray-700">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Mark CMS. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @yield('scripts')
</body>
</html>
