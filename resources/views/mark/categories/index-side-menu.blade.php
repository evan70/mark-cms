@extends('mark.layouts.side-menu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Categories</h1>
        <a href="{{ url('/mark/categories/create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            Create Category
        </a>
    </div>

    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Slug</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach($categories as $category)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $category->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-300">
                            @if($category->translations->isNotEmpty())
                                {{ $category->translations->first()->name }}
                            @else
                                <span class="text-gray-500">No translation</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-400">{{ $category->slug }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ url('/mark/categories/' . $category->id . '/edit') }}" class="text-indigo-400 hover:text-indigo-300 mr-3">Edit</a>
                        <a href="{{ url('/mark/categories/' . $category->id . '/delete') }}" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
                @endforeach

                @if($categories->isEmpty())
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">No categories found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
