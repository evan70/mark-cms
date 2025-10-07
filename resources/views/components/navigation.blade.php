<nav class="fixed top-0 w-full bg-transparent backdrop-blur-sm shadow-lg z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ get_language_prefix($language ?? 'en') }}" class="text-xl font-bold">
                {{ config('app.name', 'Multilingual CMS') }}
            </a>

            <!-- Main Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ get_language_prefix($language) }}" class="nav-link">
                    {{ __('Home') }}
                </a>
                <a href="{{ get_language_prefix($language) }}/articles" class="nav-link">
                    {{ __('Articles') }}
                </a>
                <a href="{{ get_language_prefix($language) }}/categories" class="nav-link">
                    {{ __('Categories') }}
                </a>
                <!-- Search Form -->
                @include('components.search-form')
                <!-- Language Switcher -->
                @include('components.language-switcher')
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden" id="mobile-menu-button" aria-label="Toggle mobile menu" aria-expanded="false" aria-controls="mobile-menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-900/50 backdrop-blur-sm rounded-lg mt-2">
                <a href="{{ get_language_prefix($language) }}" class="block px-3 py-2 rounded-md hover:bg-gray-700">
                    {{ __('Home') }}
                </a>
                <a href="{{ get_language_prefix($language) }}/articles" class="block px-3 py-2 rounded-md hover:bg-gray-700">
                    {{ __('Articles') }}
                </a>
                @include('components.language-switcher', ['isMobile' => true])
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    const isExpanded = mobileMenu.classList.contains('hidden') ? false : true;

    // Toggle the menu visibility
    mobileMenu.classList.toggle('hidden');

    // Update the aria-expanded attribute
    this.setAttribute('aria-expanded', !isExpanded);
});
</script>
@endpush
