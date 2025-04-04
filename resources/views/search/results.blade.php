@extends('layouts.app')

@push('styles')
<style>
    mark {
        background-color: rgba(124, 58, 237, 0.3); /* purple-600 with opacity */
        color: #f3f4f6; /* gray-100 */
        padding: 0 2px;
        border-radius: 2px;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Search Results</h1>

        <form action="/{{ $language ?? config('app.default_language', 'sk') }}/search" method="GET" class="mb-8">
            <div class="flex">
                <input type="text"
                       name="q"
                       value="{{ $query }}"
                       placeholder="Search..."
                       class="flex-grow px-4 py-2 rounded-l-md bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                <button type="submit"
                        class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Search
                </button>
            </div>
        </form>

        @if(empty($query))
            <div class="text-center py-8">
                <p class="text-gray-400">Enter a search term to find content.</p>
            </div>
        @elseif(empty($results))
            <div class="text-center py-8">
                <p class="text-gray-400">No results found for "{{ $query }}".</p>
                <p class="mt-4 text-gray-500">Try different keywords or check your spelling.</p>
            </div>
        @else
            <p class="mb-4 text-gray-400">Found {{ count($results) }} results for "{{ $query }}"</p>

            <div class="space-y-6">
                @foreach($results as $result)
                    <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-750 transition-colors">
                        <a href="{{ $result['url'] }}" class="block">
                            <h2 class="text-xl font-semibold text-purple-400 mb-2">{{ $result['title'] }}</h2>
                            <p class="text-gray-300 mb-2">{!! $result['excerpt'] !!}</p>
                            <p class="text-gray-500 text-sm">{{ $result['url'] }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
