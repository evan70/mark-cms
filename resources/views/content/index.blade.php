@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-bold mb-4">
                @if($category)
                    {{ ucfirst(str_replace('-', ' ', $category)) }}
                @else
                    {{ __('Articles') }}
                @endif
            </h1>
            
            @if($category)
            <nav class="text-sm text-gray-350 mb-4">
                <ol class="flex flex-wrap items-center">
                    <li>
                        <a href="{{ get_language_prefix($language) }}/content" class="hover:text-white">{{ __('Articles') }}</a>
                    </li>
                    <li class="mx-2">/</li>
                    
                    @php
                        $path = '';
                        $parts = explode('/', $category);
                    @endphp
                    
                    @foreach($parts as $index => $part)
                        @php
                            $path .= ($index > 0 ? '/' : '') . $part;
                            $isLast = $index === count($parts) - 1;
                        @endphp
                        
                        <li>
                            @if($isLast)
                                <span class="text-white">{{ ucfirst(str_replace('-', ' ', $part)) }}</span>
                            @else
                                <a href="{{ get_language_prefix($language) }}/content?category={{ $path }}" class="hover:text-white">
                                    {{ ucfirst(str_replace('-', ' ', $part)) }}
                                </a>
                                <span class="mx-2">/</span>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>
            @endif
        </header>

        @if(empty($articles))
            <div class="bg-gray-800 rounded-lg p-8 text-center">
                <p class="text-gray-250 mb-4">{{ __('No articles found.') }}</p>
                <a href="{{ get_language_prefix($language) }}/content" class="text-purple-400 hover:text-purple-300">
                    {{ __('View all articles') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        @if(isset($article['featured_image']) && $article['featured_image'])
                            <img src="{{ $article['featured_image'] }}" 
                                 alt="{{ $article['title'] ?? 'Article image' }}" 
                                 class="w-full h-48 object-cover">
                        @endif
                        
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-2">
                                <a href="{{ get_language_prefix($language) }}/content/{{ $article['slug'] }}{{ $category ? '?category=' . urlencode($category) : '' }}"
                                   class="hover:text-purple-400 transition-colors">
                                    {{ $article['title'] ?? 'Untitled' }}
                                </a>
                            </h2>
                            
                            @if(isset($article['excerpt']) && $article['excerpt'])
                                <p class="text-gray-250 mb-4">{{ $article['excerpt'] }}</p>
                            @elseif(isset($article['content']))
                                <p class="text-gray-250 mb-4">{{ str_limit(strip_tags($article['content']), 150) }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-sm text-gray-350">
                                <div>
                                    @if(isset($article['date']))
                                        <time datetime="{{ $article['date'] }}">
                                            {{ date('d.m.Y', strtotime($article['date'])) }}
                                        </time>
                                    @endif
                                </div>
                                
                                <div>
                                    @if(isset($article['author']))
                                        <span>{{ $article['author'] }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if(isset($article['tags']) && !empty($article['tags']))
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach($article['tags'] as $tag)
                                        <span class="inline-block bg-gray-700 rounded-full px-3 py-1 text-xs text-gray-200">
                                            {{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
