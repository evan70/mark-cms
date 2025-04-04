@extends('layouts.error')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="text-center px-6">
        <div class="mb-8">
            <h1 class="text-9xl font-bold bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">404</h1>
            <p class="mt-4 text-2xl text-gray-250">Page not found</p>
        </div>

        <p class="mb-8 text-gray-350">
            The page you're looking for doesn't exist or has been moved.
        </p>

        <div class="space-x-4">
            <a href="javascript:history.back()"
               class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Go Back
            </a>

            <a href="/"
               class="inline-flex items-center px-4 py-2 border border-gray-700 text-base font-medium rounded-md text-gray-250 bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Home Page
            </a>
        </div>
    </div>
</div>
@endsection