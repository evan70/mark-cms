@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto">
        @if($article->featured_image)
            <img src="{{ $article->featured_image }}"
                 alt="{{ $article->translations->first()?->title }}"
                 class="w-full h-64 md:h-96 object-cover rounded-lg mb-8">
        @endif

        <h1 class="text-4xl font-bold mb-4">{{ $article->translations->first()?->title }}</h1>

        <div class="text-gray-250 mb-8">
            <time datetime="{{ $article->published_at }}">
                {{ date('d.m.Y', strtotime($article->published_at)) }}
            </time>
        </div>

        <div class="prose prose-lg prose-invert max-w-none">
            {!! $content !!}
        </div>
    </article>
</div>
@endsection
