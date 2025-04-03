@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Create User</h1>
        <a href="{{ url('/mark/users') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Back to Users
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
        <form action="{{ url('/mark/users/create') }}" method="POST">
            {!! csrf_fields() !!}

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ $data['name'] ?? '' }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                       {{ isset($errors['name']) ? 'border-red-500' : '' }}">
                @if(isset($errors['name']))
                    <p class="text-red-500 text-xs italic mt-1">{{ $errors['name'] }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ $data['email'] ?? '' }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                       {{ isset($errors['email']) ? 'border-red-500' : '' }}">
                @if(isset($errors['email']))
                    <p class="text-red-500 text-xs italic mt-1">{{ $errors['email'] }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                       {{ isset($errors['password']) ? 'border-red-500' : '' }}">
                @if(isset($errors['password']))
                    <p class="text-red-500 text-xs italic mt-1">{{ $errors['password'] }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ isset($data['is_active']) && $data['is_active'] ? 'checked' : '' }}
                           class="mr-2">
                    <label for="is_active" class="text-gray-700 text-sm font-bold">Active</label>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="email_verified" id="email_verified" value="1"
                           {{ isset($data['email_verified']) && $data['email_verified'] ? 'checked' : '' }}
                           class="mr-2">
                    <label for="email_verified" class="text-gray-700 text-sm font-bold">Email Verified</label>
                </div>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
