@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">{{ __('Articles') }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                @if($article->featured_image)
                    <img src="{{ str_starts_with($article->featured_image, '/uploads/')
                        ? $article->featured_image
                        : '/uploads/' . $article->featured_image }}"
                         alt="{{ $article->title }}"
                         class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-2">
                        <a href="/{{ $language }}/article/{{ $article->slug }}"
                           class="hover:text-blue-400"
                           title="{{ $article->title }}"
                           aria-label="{{ __('Read article') }}: {{ $article->title }}">
                            {{ $article->title }}
                        </a>
                    </h2>
                    <p class="text-gray-250 mb-4">{{ $article->perex }}</p>
                    <div class="text-sm text-gray-350">
                        {{ date('d.m.Y', strtotime($article->published_at)) }}
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    @if($pagination && $pagination->hasPages())
        <div class="mt-8 flex justify-center gap-4">
            @if($pagination->currentPage() > 1)
                <a href="{{ $pagination->previousPageUrl() }}"
                   class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Previous
                </a>
            @endif

            @if($pagination->currentPage() < $pagination->totalPages())
                <a href="{{ $pagination->nextPageUrl() }}"
                   class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Next
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
