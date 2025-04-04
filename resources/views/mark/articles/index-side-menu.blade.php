@extends('mark.layouts.side-menu')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Articles</h1>
        <a href="{{ url('/mark/articles/create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            Create Article
        </a>
    </div>

    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Slug</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Created</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach($articles as $article)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $article->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-300">
                            @if($article->translations->isNotEmpty())
                                {{ $article->translations->first()->title }}
                            @else
                                <span class="text-gray-500">No translation</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-400">{{ $article->slug }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $article->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $article->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                        {{ $article->created_at->format('Y-m-d') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ url('/mark/articles/' . $article->id . '/edit') }}" class="text-indigo-400 hover:text-indigo-300 mr-3">Edit</a>
                        <a href="{{ url('/mark/articles/' . $article->id . '/delete') }}" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this article?')">Delete</a>
                    </td>
                </tr>
                @endforeach

                @if($articles->isEmpty())
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">No articles found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
