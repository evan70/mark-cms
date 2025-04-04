@extends('mark.layouts.side-menu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Tags</h1>
        <a href="{{ url('/mark/tags/create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            Create Tag
        </a>
    </div>

    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Slug</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Articles</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach($tags as $tag)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $tag->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-300">
                            @if($tag->translations->isNotEmpty())
                                {{ $tag->translations->first()->name }}
                            @else
                                <span class="text-gray-500">No translation</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-400">{{ $tag->slug }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                        {{ $tag->articles_count ?? $tag->articles()->count() }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ url('/mark/tags/' . $tag->id . '/edit') }}" class="text-indigo-400 hover:text-indigo-300 mr-3">Edit</a>
                        <a href="{{ url('/mark/tags/' . $tag->id . '/delete') }}" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this tag?')">Delete</a>
                    </td>
                </tr>
                @endforeach

                @if($tags->isEmpty())
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">No tags found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
