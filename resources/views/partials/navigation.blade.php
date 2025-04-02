<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="/" class="text-white font-bold text-xl">
                        {{ config('app.name', 'App') }}
                    </a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('Home') }}
                        </a>
                        <a href="/articles" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('Articles') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <!-- Language Switcher -->
                    <div class="relative ml-3">
                        <select onchange="window.location.href=this.value" 
                                class="bg-gray-700 text-white rounded-md px-3 py-2 text-sm font-medium">
                            <option value="/en" {{ $language === 'en' ? 'selected' : '' }}>English</option>
                            <option value="/sk" {{ $language === 'sk' ? 'selected' : '' }}>Slovensky</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>