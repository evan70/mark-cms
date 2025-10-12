{{--
    Article Link Component V2
    Usage:
    <x-article-link-v2
        :article="$article"
        :language="$language"
        :show-date="true"
        :show-read-more="true"
        class="custom-class"
    />
--}}

@props([
    'article',
    'language',
    'showDate' => false,
    'showReadMore' => false,
    'class' => 'text-purple-400 hover:text-purple-300',
    'dateClass' => 'text-sm text-gray-150 ml-2'
])

@php
    // Check if required variables are provided
    if (!isset($article)) {
        throw new Exception('Article variable is required for article-link-v2 component');
    }
    if (!isset($language)) {
        throw new Exception('Language variable is required for article-link-v2 component');
    }

    // Get the article translation
    $translation = $article->translations->first();
    $title = $translation->title ?? 'Article';

    // Generate URL
    $url = get_language_prefix($language) . "/article/{$article->slug}";
@endphp

<div class="article-link-container">
    <a href="{{ $url }}"
       class="{{ $class }}"
       title="{{ $title }}"
       aria-label="{{ __('Read article') }}: {{ $title }}">

        @if($showReadMore)
            <span>{{ __('Read More') }}</span>
            <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        @else
            {{ $slot ?? $title }}
        @endif
    </a>

    @if($showDate)
        <span class="{{ $dateClass }}">
            {{ $article->published_at ? $article->published_at->format('d.m.Y') : '' }}
        </span>
    @endif
</div>
