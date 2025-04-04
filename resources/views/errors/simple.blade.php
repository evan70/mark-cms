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

    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #111827; /* bg-gray-900 */
            color: #f3f4f6; /* text-gray-100 */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #111827; /* bg-gray-900 */
            border-bottom: 1px solid #1f2937; /* border-gray-800 */
            padding: 1rem;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .items-center {
            align-items: center;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-white {
            color: #ffffff;
        }

        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }

        .error-container {
            text-align: center;
            max-width: 36rem;
            width: 100%;
        }

        .error-code {
            font-size: 9rem;
            font-weight: 700;
            background: linear-gradient(to right, #a78bfa, #3b82f6); /* from-purple-400 to-blue-500 */
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
            margin-bottom: 1rem;
        }

        .error-title {
            font-size: 1.5rem;
            color: #e5e7eb; /* text-gray-250 */
            margin-bottom: 1.5rem;
        }

        .error-message {
            color: #9ca3af; /* text-gray-350 */
            margin-bottom: 2rem;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .button-primary {
            background-color: #7c3aed; /* bg-purple-600 */
            color: #ffffff;
            border: none;
        }

        .button-primary:hover {
            background-color: #6d28d9; /* bg-purple-700 */
        }

        .button-secondary {
            background-color: #1f2937; /* bg-gray-800 */
            color: #e5e7eb; /* text-gray-250 */
            border: 1px solid #374151; /* border-gray-700 */
        }

        .button-secondary:hover {
            background-color: #374151; /* bg-gray-700 */
        }

        .search-container {
            max-width: 28rem;
            width: 100%;
            margin: 0 auto;
        }

        .search-title {
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 1rem;
        }

        .search-form {
            display: flex;
        }

        .search-input {
            flex-grow: 1;
            padding: 0.5rem 1rem;
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
            background-color: #1f2937; /* bg-gray-800 */
            border: 1px solid #374151; /* border-gray-700 */
            color: #ffffff;
        }

        .search-input:focus {
            outline: none;
            border-color: #7c3aed; /* ring-purple-500 */
            box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.3);
        }

        .search-button {
            padding: 0.5rem 1rem;
            background-color: #7c3aed; /* bg-purple-600 */
            color: #ffffff;
            border: none;
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #6d28d9; /* bg-purple-700 */
        }

        footer {
            background-color: #111827; /* bg-gray-900 */
            border-top: 1px solid #1f2937; /* border-gray-800 */
            padding: 2rem 1rem;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .footer-content {
                flex-direction: row;
                justify-content: space-between;
            }
        }

        .copyright {
            color: #9ca3af; /* text-gray-400 */
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-link {
            color: #9ca3af; /* text-gray-400 */
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-white">
                    {{ config('app.name', 'Mark CMS') }}
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="error-container">
            <div class="error-code">{{ $statusCode ?? '500' }}</div>
            <div class="error-title">{{ $title ?? 'Error' }}</div>
            <div class="error-message">{{ $error['message'] ?? 'Something went wrong on our servers.' }}</div>

            <div class="button-container">
                <a href="javascript:history.back()" class="button button-primary">
                    Go Back
                </a>

                <a href="{{ url('/') }}" class="button button-secondary">
                    Home Page
                </a>
            </div>
        </div>

        <div class="search-container">
            <h2 class="search-title">Looking for something?</h2>
            <form action="/{{ $language ?? config('app.default_language', 'sk') }}/search" method="GET" class="search-form">
                <input type="text"
                       name="q"
                       placeholder="Search in content..."
                       class="search-input">
                <button type="submit" class="search-button">
                    Search
                </button>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="copyright">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Mark CMS') }}. All rights reserved.
                </div>

                <div class="footer-links">
                    <a href="{{ url('/' . ($language ?? config('app.default_language', 'sk')) . '/privacy') }}" class="footer-link">Privacy Policy</a>
                    <a href="{{ url('/' . ($language ?? config('app.default_language', 'sk')) . '/terms') }}" class="footer-link">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
