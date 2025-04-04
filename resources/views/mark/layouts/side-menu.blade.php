<!DOCTYPE html>
<html lang="en" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mark CMS' }}</title>
    <link href="/css/app.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-900 text-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <!-- Sidebar component -->
                <div class="flex flex-col flex-grow bg-gray-800 border-r border-gray-700 pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <a href="/mark/to-website" class="text-xl font-bold text-white hover:text-purple-400" title="Go to Website">Mark CMS</a>
                    </div>
                    <div class="mt-5 flex-grow flex flex-col">
                        <nav class="flex-1 px-2 space-y-1">
                            <!-- Website -->
                            <a href="/mark/to-website" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
                                <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                Website
                            </a>

                            <!-- Dashboard -->
                            <a href="/mark" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>

                            <!-- Content Management -->
                            <div class="pt-2 pb-1">
                                <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</h3>
                            </div>

                            <a href="/mark/content" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark/content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark/content*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                Content
                            </a>

                            <a href="/mark/ai-content" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark/ai-content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark/ai-content*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                AI Content
                            </a>

                            <a href="/mark/categories" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark/categories*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark/categories*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Categories
                            </a>

                            <a href="/mark/tags" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark/tags*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark/tags*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Tags
                            </a>

                            <a href="/mark/media" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark/media*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark/media*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Media
                            </a>

                            <!-- User Management -->
                            <div class="pt-2 pb-1">
                                <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Users</h3>
                            </div>

                            <a href="/mark/users" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark/users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark/users*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Users
                            </a>

                            <a href="/mark/mark-users" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->is('mark/mark-users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-3 h-6 w-6 {{ request()->is('mark/mark-users*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Mark Users
                            </a>
                        </nav>
                    </div>
                    <div class="flex-shrink-0 flex border-t border-gray-700 p-4">
                        <div class="flex-shrink-0 w-full group block">
                            <div class="flex items-center">
                                <div>
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500">
                                        <span class="text-sm font-medium leading-none text-white">A</span>
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-white">Admin User</p>
                                    <div class="flex space-x-2 text-sm text-gray-400">
                                        <a href="/mark/profile" class="hover:text-gray-300">Profile</a>
                                        <span aria-hidden="true">&middot;</span>
                                        <a href="{{ url('/mark/logout') }}" class="hover:text-gray-300">Sign out</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden" x-data="{ sidebarOpen: false }">
            <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
            <div x-show="sidebarOpen" class="fixed inset-0 flex z-40">
                <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-600 opacity-75"></div>
                </div>
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
                    <div x-show="sidebarOpen" @click.away="sidebarOpen = false" class="absolute top-0 right-0 -mr-12 pt-2">
                        <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-4">
                            <span class="text-xl font-bold text-white">Mark CMS</span>
                        </div>
                        <nav class="mt-5 px-2 space-y-1">
                            <!-- Dashboard -->
                            <a href="/mark" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('mark') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-4 h-6 w-6 {{ request()->is('mark') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>

                            <!-- Content Management -->
                            <div class="pt-2 pb-1">
                                <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</h3>
                            </div>

                            <a href="/mark/content" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('mark/content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-4 h-6 w-6 {{ request()->is('mark/content*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                Content
                            </a>

                            <a href="/mark/ai-content" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('mark/ai-content*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-4 h-6 w-6 {{ request()->is('mark/ai-content*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                AI Content
                            </a>

                            <a href="/mark/categories" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('mark/categories*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-4 h-6 w-6 {{ request()->is('mark/categories*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Categories
                            </a>

                            <a href="/mark/tags" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('mark/tags*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-4 h-6 w-6 {{ request()->is('mark/tags*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Tags
                            </a>

                            <!-- User Management -->
                            <div class="pt-2 pb-1">
                                <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Users</h3>
                            </div>

                            <a href="/mark/users" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('mark/users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-4 h-6 w-6 {{ request()->is('mark/users*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Users
                            </a>

                            <a href="/mark/mark-users" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->is('mark/mark-users*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                <svg class="mr-4 h-6 w-6 {{ request()->is('mark/mark-users*') ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Mark Users
                            </a>
                        </nav>
                    </div>
                    <div class="flex-shrink-0 flex border-t border-gray-700 p-4">
                        <div class="flex-shrink-0 group block">
                            <div class="flex items-center">
                                <div>
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500">
                                        <span class="text-sm font-medium leading-none text-white">A</span>
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-white">Admin User</p>
                                    <div class="flex space-x-2 text-sm text-gray-400">
                                        <a href="/mark/profile" class="hover:text-gray-300">Profile</a>
                                        <span aria-hidden="true">&middot;</span>
                                        <a href="{{ url('/mark/logout') }}" class="hover:text-gray-300">Sign out</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0 w-14">
                    <!-- Force sidebar to shrink to fit close icon -->
                </div>
            </div>

            <!-- Top bar -->
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-gray-800 border-b border-gray-700">
                <button @click="sidebarOpen = true" class="px-4 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white md:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex items-center">
                        <span class="text-xl font-bold text-white md:hidden">Mark CMS</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
