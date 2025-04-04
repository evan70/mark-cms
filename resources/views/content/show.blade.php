@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto">
        @if(isset($article['featured_image']) && $article['featured_image'])
            <img src="{{ $article['featured_image'] }}"
                 alt="{{ $article['title'] ?? 'Article image' }}"
                 class="w-full h-64 md:h-96 object-cover rounded-lg mb-8">
        @endif

        <header class="mb-8">
            <h1 class="text-4xl font-bold mb-4">{{ $article['title'] ?? 'Untitled' }}</h1>

            <div class="flex flex-wrap items-center text-gray-250 mb-4">
                @if(isset($article['date']))
                    <time datetime="{{ $article['date'] }}" class="mr-4">
                        {{ date('d.m.Y', strtotime($article['date'])) }}
                    </time>
                @endif

                @if(isset($article['author']))
                    <span class="mr-4">
                        {{ __('By') }} {{ $article['author'] }}
                    </span>
                @endif

                @if(isset($article['category']))
                    <span>
                        {{ __('In') }}
                        <a href="/{{ $language }}/content?category={{ $article['category'] }}"
                           class="text-purple-400 hover:text-purple-300">
                            {{ ucfirst(str_replace('-', ' ', $article['category'])) }}
                        </a>
                    </span>
                @endif
            </div>

            @if(isset($article['tags']) && !empty($article['tags']))
                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($article['tags'] as $tag)
                        <span class="inline-block bg-gray-700 rounded-full px-3 py-1 text-sm text-gray-200">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif

            @if(isset($article['excerpt']) && $article['excerpt'])
                <div class="text-xl text-gray-250 italic border-l-4 border-purple-500 pl-4 py-2">
                    {{ $article['excerpt'] }}
                </div>
            @endif
        </header>

        <div class="prose prose-lg prose-invert max-w-none">
            {!! $article['content'] ?? '' !!}
        </div>

        <footer class="mt-12 pt-8 border-t border-gray-700">
            <div class="flex flex-wrap justify-between">
                <a href="/{{ $language }}/content{{ $category ? '?category=' . urlencode($category) : '' }}"
                   class="inline-flex items-center text-purple-400 hover:text-purple-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Back to articles') }}
                </a>

                <div class="flex space-x-4">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url($_SERVER['REQUEST_URI'])) }}&text={{ urlencode($article['title'] ?? 'Article') }}"
                       target="_blank"
                       class="text-blue-400 hover:text-blue-300"
                       aria-label="Share on Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url($_SERVER['REQUEST_URI'])) }}"
                       target="_blank"
                       class="text-blue-600 hover:text-blue-500"
                       aria-label="Share on Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url($_SERVER['REQUEST_URI'])) }}&title={{ urlencode($article['title'] ?? 'Article') }}"
                       target="_blank"
                       class="text-blue-500 hover:text-blue-400"
                       aria-label="Share on LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </footer>
    </article>
</div>
@endsection
