@extends('layouts.main')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">{{ __('Categories') }}</h1>
    
    @if(count($categories) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                @php
                    $translation = $category->translations->first();
                    if (!$translation) continue;
                @endphp
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2 text-gray-100">
                            {{ $translation->name }}
                        </h2>
                        @if($translation->description)
                            <p class="text-gray-400 mb-4">
                                {{ $translation->description }}
                            </p>
                        @endif
                        <a href="{{ get_language_prefix($language) }}/categories/{{ $category->slug }}"
                           class="text-blue-400 hover:text-blue-300">
                            {{ __('View Category') }} →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-400 text-center">{{ __('No categories found.') }}</p>
    @endif
</div>
@endsection
