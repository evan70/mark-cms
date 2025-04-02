<!DOCTYPE html>
<html class="h-full bg-gray-900">
<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white">
                Admin Login
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="/admin/login" method="POST">
                @if(isset($error))
                    <div class="rounded-md bg-red-500 p-4 mb-4">
                        <p class="text-sm text-white">{{ $error }}</p>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-white">Email</label>
                    <input id="email" name="email" type="email" required 
                           class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-white">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                </div>

                <div>
                    <button type="submit" 
                            class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>