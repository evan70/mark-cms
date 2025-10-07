{{--
    Article Link Component
    Usage:
    @include('components.article-link', [
        'article' => $article,
        'language' => $language,
        'translation' => $translation,
        'class' => 'optional-css-class'
    ])
--}}

@php
    // Check if required variables are provided
    if (!isset($article)) {
        throw new Exception('Article variable is required for article-link component');
    }
    if (!isset($language)) {
        throw new Exception('Language variable is required for article-link component');
    }

    // Ensure we have a translation
    $articleTranslation = $translation ?? $article->translations->first();
    $title = $articleTranslation->title ?? 'Article';
    $cssClass = $class ?? '';
@endphp

<a href="{{ get_language_prefix($language) }}/article/{{ $translation->slug }}"
   class="{{ $cssClass }}"
   title="{{ $title }}"
   aria-label="{{ __('Read article') }}: {{ $title }}">
    @if(isset($slot) && !empty($slot))
        {{ $slot }}
    @else
        {{ $title }}
    @endif
</a>
