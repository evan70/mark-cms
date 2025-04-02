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
    // Ensure we have a translation
    $articleTranslation = $translation ?? $article->translations->first();
    $title = $articleTranslation->title ?? 'Article';
    $cssClass = $class ?? '';
@endphp

<a href="/{{ $language }}/article/{{ $article->slug }}"
   class="{{ $cssClass }}"
   title="{{ $title }}"
   aria-label="{{ __('Read article') }}: {{ $title }}">
    @if(isset($slot) && !empty($slot))
        {{ $slot }}
    @else
        {{ $title }}
    @endif
</a>
