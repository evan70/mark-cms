@extends('mark.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Content Management {{ $category ? '- ' . ucfirst($category) : '' }}</h1>

            @if(!empty($breadcrumbs))
            <div class="flex items-center text-sm text-gray-400 mt-2">
                @foreach($breadcrumbs as $index => $breadcrumb)
                    @if($index > 0)
                        <span class="mx-2">/</span>
                    @endif

                    @if($breadcrumb['path'] === null || $loop->last)
                        <span>{{ $breadcrumb['name'] }}</span>
                    @else
                        <a href="{{ url('/mark/content') }}{{ $breadcrumb['path'] ? '?category=' . $breadcrumb['path'] : '' }}" class="text-blue-400 hover:text-blue-300">{{ $breadcrumb['name'] }}</a>
                    @endif
                @endforeach
            </div>
            @endif
        </div>

        <div class="flex space-x-2">
            @if($category)
            <a href="{{ url('/mark/content/create?category=' . urlencode($category) . '&is_index=1') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Index
            </a>
            @endif
            <a href="{{ url('/mark/content/create') }}{{ $category ? '?category=' . urlencode($category) : '' }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Create Article
            </a>
        </div>
    </div>

    @if(!empty($subdirectories))
    <div class="mb-6">
        <h2 class="text-xl font-bold mb-3">Directories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($subdirectories as $directory)
            <a href="{{ url('/mark/content?category=' . urlencode($directory['path'])) }}" class="bg-gray-800 hover:bg-gray-700 p-4 rounded-lg border border-gray-700 flex items-center">
                <svg class="h-6 w-6 text-yellow-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <span class="text-gray-300">{{ ucfirst($directory['name']) }}</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Language</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @foreach($articles as $article)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-300">{{ $article['title'] ?? 'Untitled' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-400">
                            @if($article['is_index'] ?? false)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Index</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Article</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                        {{ $article['date'] ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ ($article['status'] ?? '') === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($article['status'] ?? 'draft') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                        {{ strtoupper($article['language'] ?? 'sk') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ url('/mark/content/' . urlencode($article['filename']) . '/edit') }}{{ $category ? '?category=' . urlencode($category) : '' }}" class="text-indigo-400 hover:text-indigo-300 mr-3">Edit</a>
                        <a href="{{ url('/mark/content/' . urlencode($article['filename']) . '/delete') }}{{ $category ? '?category=' . urlencode($category) : '' }}" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this article?')">Delete</a>
                    </td>
                </tr>
                @endforeach

                @if(empty($articles))
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">No articles found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
