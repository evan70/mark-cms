@extends('layouts.main')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-20">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-10 md:mb-0" data-animation="slideRight">
                <h1 class="text-5xl font-bold mb-6 bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
                    Vytvárame digitálne<br>riešenia budúcnosti
                </h1>
                <p class="text-xl text-gray-250 mb-8">
                    Špecializujeme sa na vývoj moderných webových aplikácií a mobilných riešení s dôrazom na výkon a používateľský zážitok.
                </p>
                <div class="flex gap-4">
                    <a href="/{{ $language }}/contact" class="btn-primary bg-purple-600 hover:bg-purple-700">
                        Začnime spoluprácu
                    </a>
                    <a href="/{{ $language }}/portfolio" class="btn-secondary border border-purple-600 hover:bg-purple-600/10">
                        Naše projekty
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 relative" data-animation="slideLeft">
                <div class="relative z-10 bg-gradient-to-br from-purple-600/20 to-blue-600/20 rounded-2xl p-8">
                    <pre class="text-sm font-mono text-gray-150"><code>
class ResponsiveSK {
    build(idea) {
        return new Promise((success) => {
            const solution = this.innovate(idea);
            success(solution);
        });
    }
}</code></pre>
                </div>
                <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-r from-purple-500/10 to-blue-500/10 blur-3xl -z-10"></div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="bg-gray-800/50 py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-16" data-animation="fadeIn">Naše služby</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="service-card" data-animation="slideUp" data-delay="0">
                    <div class="bg-gray-800 rounded-xl p-6 h-full border border-purple-500/20 hover:border-purple-500/50 transition-all">
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-white">Web Development</h3>
                        <p class="text-gray-150">Moderné webové aplikácie postavené na najnovších technológiách s dôrazom na výkon a škálovateľnosť.</p>
                    </div>
                </div>

                <div class="service-card" data-animation="slideUp" data-delay="0.2">
                    <div class="bg-gray-800 rounded-xl p-6 h-full border border-blue-500/20 hover:border-blue-500/50 transition-all">
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-white">Mobile Development</h3>
                        <p class="text-gray-150">Natívne a cross-platform mobilné aplikácie pre iOS a Android s intuitívnym používateľským rozhraním.</p>
                    </div>
                </div>

                <div class="service-card" data-animation="slideUp" data-delay="0.4">
                    <div class="bg-gray-800 rounded-xl p-6 h-full border border-green-500/20 hover:border-green-500/50 transition-all">
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4 text-white">DevOps & Cloud</h3>
                        <p class="text-gray-150">Automatizácia, monitoring a správa cloudovej infraštruktúry pre maximálnu dostupnosť vašich aplikácií.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Articles & Categories Section -->
    <div class="container mx-auto px-4 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Latest Articles -->
            <div class="space-y-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold" data-animation="fadeIn">{{ __('Latest Articles') }}</h2>
                    <a href="/{{ $language }}/articles"
                       class="text-purple-400 hover:text-purple-300 flex items-center gap-2 group">
                        {{ __('View All') }}
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @foreach($latestArticles as $article)
                    @php
                        $translation = $article->translations->first();
                    @endphp
                    @if($translation)
                        <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-purple-500/10 hover:border-purple-500/30"
                             data-animation="slideUp" data-delay="{{ $loop->iteration * 0.1 }}">
                            <div class="flex flex-col md:flex-row">
                                @if($article->featured_image)
                                    <div class="md:w-1/3">
                                        <img src="{{ str_starts_with($article->featured_image, '/uploads/')
                                            ? $article->featured_image
                                            : '/uploads/' . $article->featured_image }}"
                                             alt="{{ $translation->title }}"
                                             class="w-full h-48 md:h-full object-cover">
                                    </div>
                                @endif
                                <div class="p-6 md:w-2/3">
                                    <h3 class="text-xl font-bold mb-2 text-gray-100 hover:text-purple-400 transition-colors">
                                        @include('components.article-link', [
                                            'article' => $article,
                                            'language' => $language,
                                            'translation' => $translation,
                                            'class' => 'text-gray-100 hover:text-purple-400 transition-colors'
                                        ])
                                    </h3>
                                    <p class="text-gray-150 mb-4 line-clamp-2">
                                        {{ $translation->perex }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-150">
                                            {{ $article->published_at->format('d.m.Y') }}
                                        </span>
                                        <a href="/{{ $language }}/article/{{ $article->slug }}"
                                           class="text-purple-400 hover:text-purple-300 text-sm flex items-center gap-1"
                                           title="{{ $translation->title }}"
                                           aria-label="{{ __('Read article') }}: {{ $translation->title }}">
                                            <span>{{ __('Read More') }}</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Categories -->
            <div class="space-y-6">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold" data-animation="fadeIn">{{ __('Categories') }}</h2>
                    <a href="{{ $baseUrl }}/{{ $language }}/categories"
                       class="text-purple-400 hover:text-purple-300 flex items-center gap-2 group">
                        {{ __('View All') }}
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($categories as $category)
                        @php
                            $translation = $category->translations->first();
                        @endphp
                        @if($translation)
                            <div class="bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border border-blue-500/10 hover:border-blue-500/30"
                                 data-animation="slideUp" data-delay="{{ $loop->iteration * 0.1 }}">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold mb-2 text-gray-100 hover:text-blue-400 transition-colors">
                                            <a href="{{ $baseUrl }}/{{ $language }}/categories/{{ $category->slug }}">
                                                {{ $translation->name }}
                                            </a>
                                        </h3>
                                        @if($translation->description)
                                            <p class="text-gray-400 mb-4 line-clamp-2">
                                                {{ $translation->description }}
                                            </p>
                                        @endif
                                        <a href="{{ $baseUrl }}/{{ $language }}/categories/{{ $category->slug }}"
                                           class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-1">
                                            {{ __('Browse Category') }}
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Tech Stack Section -->
    <div class="container mx-auto px-4 py-20">
        <h2 class="text-3xl font-bold text-center mb-16" data-animation="fadeIn">Technológie</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8" data-animation="fadeIn" data-delay="0.2">
            <div class="tech-card flex flex-col items-center">
                <img src="/images/tech/react.svg" alt="React" class="w-16 h-16 mb-4">
                <span class="text-gray-250">React</span>
            </div>
            <div class="tech-card flex flex-col items-center">
                <img src="/images/tech/vue.svg" alt="Vue" class="w-16 h-16 mb-4">
                <span class="text-gray-250">Vue</span>
            </div>
            <div class="tech-card flex flex-col items-center">
                <img src="/images/tech/laravel.svg" alt="Laravel" class="w-16 h-16 mb-4">
                <span class="text-gray-250">Laravel</span>
            </div>
            <div class="tech-card flex flex-col items-center">
                <img src="/images/tech/node.svg" alt="Node.js" class="w-16 h-16 mb-4">
                <span class="text-gray-250">Node.js</span>
            </div>
            <div class="tech-card flex flex-col items-center">
                <img src="/images/tech/aws.svg" alt="AWS" class="w-16 h-16 mb-4">
                <span class="text-gray-250">AWS</span>
            </div>
            <div class="tech-card flex flex-col items-center">
                <img src="/images/tech/docker.svg" alt="Docker" class="w-16 h-16 mb-4">
                <span class="text-gray-250">Docker</span>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-purple-900/50 to-blue-900/50 py-20">
        <div class="container mx-auto px-4 text-center" data-animation="fadeIn">
            <h2 class="text-3xl font-bold mb-8">Pripravení začať váš projekt?</h2>
            <p class="text-xl text-gray-250 mb-8 max-w-2xl mx-auto">
                Poďme spoločne premeniť vaše nápady na realitu. Kontaktujte nás a my vám pomôžeme s realizáciou vášho projektu.
            </p>
            <a href="/{{ $language }}/contact" class="btn-primary bg-purple-600 hover:bg-purple-700">
                Kontaktujte nás
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-primary {
        @apply px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105;
    }
    .btn-secondary {
        @apply px-6 py-3 rounded-lg font-semibold transition-all duration-300;
    }
    .service-card {
        @apply transform transition-all duration-300 hover:-translate-y-2;
    }
    .tech-card {
        @apply transform transition-all duration-300 hover:scale-110;
    }
</style>
@endpush
@endsection
