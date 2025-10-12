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
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    @stack('styles')
</head>
<body class="bg-gray-900 text-white min-h-screen">
    @php
        $currentLanguage = $language ?? $_SESSION['language'] ?? config('app.default_language');
    @endphp
    <!-- Navigation -->
    @include('components.navigation')

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')


    @stack('scripts')
</body>
</html>
