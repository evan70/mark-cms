<form action="/{{ $language ?? config('app.default_language', 'sk') }}/search" method="GET" class="{{ $class ?? 'w-full' }}">
    <div class="flex">
        <input type="text"
               name="q"
               value="{{ $query ?? '' }}"
               placeholder="{{ $placeholder ?? 'Search...' }}"
               class="flex-grow px-4 py-2 rounded-l-md bg-gray-800 border border-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
        <button type="submit"
                class="px-4 py-2 bg-purple-600 text-white rounded-r-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </div>
</form>
