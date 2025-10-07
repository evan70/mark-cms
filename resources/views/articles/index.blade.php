@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">{{ __('Articles') }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($articles as $article)
            @php
                $translation = $article->translations->first();
            @endphp
            @if($translation)
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                @if($article->featured_image)
                    <img src="{{ $article->featured_image }}" alt="{{ $translation->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">{{ $translation->title }}</h2>
                    <p class="text-gray-250 mb-4">{{ str_limit($translation->perex, 150) }}</p>
                    <a href="{{ get_language_prefix($language) }}/article/{{ $translation->slug }}"
                       class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        {{ __('Read More') }}
                    </a>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
