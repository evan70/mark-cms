@extends('mark.layouts.side-menu')

@section('content')
<div class="border-4 border-dashed border-gray-700 rounded-lg p-4">
    <h1 class="text-2xl font-bold mb-4">Welcome, {{ $user->name }}!</h1>
    <p class="text-gray-300 mb-4">You are logged in as a {{ ucfirst($user->role) }}.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="bg-gray-800 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Recent Articles</h2>
            <p class="text-gray-400">View and manage your recent articles.</p>
            <a href="/mark/articles" class="mt-4 inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">View Articles</a>
        </div>

        <div class="bg-gray-800 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Your Profile</h2>
            <p class="text-gray-400">Update your profile information.</p>
            <a href="/mark/profile" class="mt-4 inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Edit Profile</a>
        </div>

        <div class="bg-gray-800 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-2">Help & Support</h2>
            <p class="text-gray-400">Get help with using the Mark CMS.</p>
            <a href="/mark/help" class="mt-4 inline-block px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">View Help</a>
        </div>
    </div>
</div>
@endsection
