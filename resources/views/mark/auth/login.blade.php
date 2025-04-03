<!DOCTYPE html>
<html lang="en" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark CMS Login</title>
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="h-full bg-gray-900 text-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold">
                    Mark CMS Login
                </h2>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Sign in to access the Mark CMS
                </p>
            </div>
            
            @if(isset($error))
                <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="/mark/login">
                {!! csrf_fields() !!}
                
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" name="email" type="email" required 
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 
                                      border border-gray-700 bg-gray-800 text-gray-100 
                                      placeholder-gray-400 focus:outline-none focus:ring-2 
                                      focus:ring-purple-500 focus:border-transparent"
                               placeholder="Email address"
                               value="{{ $email ?? '' }}">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 
                                      border border-gray-700 bg-gray-800 text-gray-100 
                                      placeholder-gray-400 focus:outline-none focus:ring-2 
                                      focus:ring-purple-500 focus:border-transparent"
                               placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" 
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 
                                      border-gray-700 rounded bg-gray-800">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-400">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="/mark/password/reset" class="font-medium text-purple-400 hover:text-purple-300">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 
                                   border border-transparent text-sm font-medium rounded-lg 
                                   text-white bg-purple-600 hover:bg-purple-700 
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 
                                   focus:ring-purple-500 transition-colors duration-200
                                   focus:ring-offset-gray-900">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
