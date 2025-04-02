<!DOCTYPE html>
<html lang="{{ $language ?? config('app.default_language', 'en') }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="h-full bg-gray-50">
    <main class="min-h-screen flex items-center justify-center">
        <div class="text-center px-6">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-gray-900">500</h1>
                <p class="mt-4 text-2xl text-gray-600">Server Error</p>
            </div>

            <p class="mb-8 text-gray-500">
                {{ $error['message'] ?? 'Something went wrong on our servers.' }}
            </p>

            <div class="space-x-4">
                <a href="javascript:history.back()"
                   class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Go Back
                </a>

                <a href="/"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Home Page
                </a>
            </div>
        </div>
    </main>
</body>
</html>
