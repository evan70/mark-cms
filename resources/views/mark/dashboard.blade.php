<!DOCTYPE html>
<html lang="en" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark CMS Dashboard</title>
    <link href="/css/app.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-gray-900 text-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Top Navigation -->
        <nav class="bg-gray-800 border-b border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-xl font-bold text-white">Mark CMS</span>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="/mark/dashboard" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                                <a href="/mark/articles" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Articles</a>
                                @if($user->hasAdminAccess())
                                <a href="/admin/dashboard" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Admin</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="ml-3 relative" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-600">
                                            <span class="text-sm font-medium leading-none text-white">{{ substr($user->name, 0, 1) }}</span>
                                        </span>
                                    </button>
                                </div>
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="/mark/profile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Your Profile</a>
                                    <a href="/mark/settings" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Settings</a>
                                    <a href="/mark/logout" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700" role="menuitem">Sign out</a>
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
                    <a href="/mark/dashboard" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                    <a href="/mark/articles" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Articles</a>
                    @if($user->hasAdminAccess())
                    <a href="/admin/dashboard" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Admin</a>
                    @endif
                </div>
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-purple-600">
                                <span class="text-sm font-medium leading-none text-white">{{ substr($user->name, 0, 1) }}</span>
                            </span>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ $user->name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="/mark/profile" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Your Profile</a>
                        <a href="/mark/settings" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Settings</a>
                        <a href="/mark/logout" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Sign out</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="px-4 py-6 sm:px-0">
                    <div class="border-4 border-dashed border-gray-700 rounded-lg p-4 h-96">
                        <h1 class="text-2xl font-bold mb-4">Welcome, {{ $user->name }}!</h1>
                        <p class="text-gray-300 mb-4">You are logged in as a {{ ucfirst($user->role) }}.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                            <div class="bg-gray-800 p-4 rounded-lg shadow">
                                <h2 class="text-xl font-semibold mb-2">Recent Articles</h2>
                                <p class="text-gray-400">View and manage your recent articles.</p>
                                <a href="/mark/articles" class="mt-4 inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">View Articles</a>
                            </div>
                            
                            <div class="bg-gray-800 p-4 rounded-lg shadow">
                                <h2 class="text-xl font-semibold mb-2">Your Profile</h2>
                                <p class="text-gray-400">Update your profile information.</p>
                                <a href="/mark/profile" class="mt-4 inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Edit Profile</a>
                            </div>
                            
                            <div class="bg-gray-800 p-4 rounded-lg shadow">
                                <h2 class="text-xl font-semibold mb-2">Help & Support</h2>
                                <p class="text-gray-400">Get help with using the Mark CMS.</p>
                                <a href="/mark/help" class="mt-4 inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">View Help</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
