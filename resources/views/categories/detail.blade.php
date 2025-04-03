@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-2">{{ $translation->name }}</h1>

    @if($translation->description)
        <p class="text-gray-400 mb-8">{{ $translation->description }}</p>
    @endif

    <h2 class="text-2xl font-bold mb-6">{{ __('Articles in this category') }}</h2>

    @if(count($category->articles) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($category->articles as $article)
                @php
                    $articleTranslation = $article->translations->first();
                    if (!$articleTranslation) continue;
                @endphp
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
                    @if($article->featured_image)
                        <img src="{{ str_starts_with($article->featured_image, '/uploads/')
                            ? $article->featured_image
                            : '/uploads/' . $article->featured_image }}"
                             alt="{{ $articleTranslation->title }}"
                             class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-100">
                            {{ $articleTranslation->title }}
                        </h3>
                        @if($articleTranslation->perex)
                            <p class="text-gray-250 mb-4">
                                {{ $articleTranslation->perex }}
                            </p>
                        @endif
                        <div class="flex justify-between items-center">
                            <a href="/{{ $language }}/articles/{{ $article->slug }}"
                               class="text-blue-400 hover:text-blue-300">
                                {{ __('Read More') }} →
                            </a>
                            <span class="text-sm text-gray-350">
                                {{ date('d.m.Y', strtotime($article->published_at)) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-400">{{ __('No articles in this category.') }}</p>
    @endif
</div>
@endsection
