<!DOCTYPE html>
<html lang="{{ $language ?? config('app.default_language', 'sk') }}" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription ?? config('app.description', 'Moderné webové a mobilné riešenia s dôrazom na výkon a používateľský zážitok. Špecializujeme sa na vývoj digitálnych produktov budúcnosti.') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? config('app.meta_keywords', 'web development, mobile development, digital solutions, responsive design, web applications') }}">
    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="h-full">
    <div class="min-h-screen bg-gray-900">
        @include('partials.navigation')

        <main class="py-10">
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
