<!DOCTYPE html>
<html lang="en" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">

    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="h-full bg-gray-900 text-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold">
                    {{ $title ?? 'Login' }}
                </h2>
                @if(isset($isMarkLogin) && $isMarkLogin)
                <p class="mt-2 text-center text-sm text-gray-400">
                    Sign in to access the Mark CMS
                </p>
                @else
                <p class="mt-2 text-center text-sm text-gray-400">
                    Sign in to your account
                </p>
                @endif
            </div>

            @if(isset($error))
                <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="/login">
                @if(isset($isMarkLogin) && $isMarkLogin)
                <input type="hidden" name="is_mark_login" value="1">
                @endif
                {!! csrf_fields() !!}

                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2
                                      border border-gray-700 bg-gray-800 text-gray-100
                                      placeholder-gray-400 focus:outline-none focus:ring-2
                                      focus:ring-blue-500 focus:border-transparent"
                               placeholder="Email address"
                               value="{{ $email ?? '' }}">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2
                                      border border-gray-700 bg-gray-800 text-gray-100
                                      placeholder-gray-400 focus:outline-none focus:ring-2
                                      focus:ring-blue-500 focus:border-transparent"
                               placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember" class="text-gray-400">Remember Me</label>
                    </div>

                    @if(isset($isMarkLogin) && $isMarkLogin)
                    <a href="/login" class="text-purple-400 hover:text-purple-300 text-sm">
                        Regular User Login
                    </a>
                    @else
                    <a href="/login?mark=1" class="text-purple-400 hover:text-purple-300 text-sm">
                        Mark CMS Login
                    </a>
                    @endif
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4
                                   border border-transparent text-sm font-medium rounded-lg
                                   text-white {{ isset($isMarkLogin) && $isMarkLogin ? 'bg-purple-600 hover:bg-purple-700 focus:ring-purple-500' : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' }}
                                   focus:outline-none focus:ring-2 focus:ring-offset-2
                                   transition-colors duration-200
                                   focus:ring-offset-gray-900">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
