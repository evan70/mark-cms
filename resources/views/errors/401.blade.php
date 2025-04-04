@extends('layouts.error')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="text-center px-6">
        <div class="mb-8">
            <h1 class="text-9xl font-bold bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">401</h1>
            <p class="mt-4 text-2xl text-gray-250">Unauthorized</p>
        </div>

        <p class="mb-8 text-gray-350">
            {{ $error['message'] ?? 'You need to be logged in to access this page.' }}
        </p>

        <div class="space-x-4">
            <a href="/login" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                Log In
            </a>

            <a href="/" 
               class="inline-flex items-center px-4 py-2 border border-gray-700 text-base font-medium rounded-md text-gray-250 bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Home Page
            </a>
        </div>
    </div>
</div>
@endsection
