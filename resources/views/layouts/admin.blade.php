<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - Multilingual CMS</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">

    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800">
            <div class="p-4">
                <h1 class="text-xl font-bold">Admin Panel</h1>
            </div>
            <nav class="mt-4">
                <a href="/admin" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a>
                <a href="/admin/articles" class="block px-4 py-2 hover:bg-gray-700">Articles</a>
                <a href="/admin/categories" class="block px-4 py-2 hover:bg-gray-700">Categories</a>
                <a href="/admin/languages" class="block px-4 py-2 hover:bg-gray-700">Languages</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-gray-800 p-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl">{{ $title ?? 'Dashboard' }}</h2>
                    <div>
                        <span class="mr-4">Admin</span>
                        <form action="/admin/logout" method="POST" class="inline">
                            <button type="submit" class="text-red-400 hover:text-red-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
