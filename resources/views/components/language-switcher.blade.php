<div class="relative language-switcher"
     x-data="{
        open: false,
        toggle() {
            this.open = !this.open;

            // Animate arrow
            const arrowIcon = document.querySelector('.arrow-icon');
            if (arrowIcon) {
                if (this.open) {
                    gsap.to(arrowIcon, {
                        rotation: 180,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                } else {
                    gsap.to(arrowIcon, {
                        rotation: 0,
                        duration: 0.3,
                        ease: 'power2.inOut'
                    });
                }
            }

            if (this.open) {
                // Animate dropdown items when opened
                setTimeout(() => {
                    document.querySelectorAll('.language-option').forEach((option, index) => {
                        gsap.fromTo(option,
                            { opacity: 0, x: -20 },
                            { opacity: 1, x: 0, duration: 0.3, delay: index * 0.1, ease: 'power2.out' }
                        );
                    });
                }, 50);
            }
        }
     }">
    <!-- Current Language Button -->
    <button @click="toggle()"
            class="language-button flex items-center space-x-2 px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 transition-colors">
        @php
            $currentLang = $lang ?? $language ?? config('app.default_language', 'sk');
        @endphp
        <img src="/images/flags/{{ $currentLang }}.svg"
             alt="{{ strtoupper($currentLang) }}"
             class="w-5 h-5 flag-icon">
        <span class="language-text">{{ strtoupper($currentLang) }}</span>
        <svg class="w-4 h-4 arrow-icon"
             :class="{'rotate-180': open}"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Language Dropdown -->
    <div x-show="open"
         @click.away="toggle()"
         class="language-dropdown absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-700 ring-1 ring-black ring-opacity-5 z-50"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95">
        <div class="py-1">
            @foreach(config('app.available_languages') as $code)
            @if($code !== $currentLang)
            <form action="/switch-lang" method="POST" class="inline">
                @csrf
                <input type="hidden" name="code" value="{{ $code }}">
                <button type="submit"
                        class="language-option flex items-center space-x-3 px-4 py-2 text-sm text-gray-150 hover:bg-gray-600 w-full text-left"
                        style="opacity: 0;">
                <img src="/images/flags/{{ $code }}.svg"
                     alt="{{ strtoupper($code) }}"
                     class="w-5 h-5 flag-icon">
                <span class="language-text">{{ strtoupper($code) }}</span>
                </button>
            </form>
            @endif
            @endforeach
        </div>
    </div>
</div>

<script>
// Wait for both DOM and Alpine.js to be ready
window.addEventListener('load', () => {
    setTimeout(() => {
        // Hover animácie pre tlačidlo
        document.querySelectorAll('.language-button').forEach(button => {
            // Ensure elements exist before animating
            const flagIcon = button.querySelector('.flag-icon');
            const languageText = button.querySelector('.language-text');

            console.log('Flag icon:', flagIcon);
            console.log('Language text:', languageText);

            if (flagIcon && languageText) {
                button.addEventListener('mouseenter', () => {
                    gsap.to(flagIcon, {
                        scale: 1.1,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                    gsap.to(languageText, {
                        x: 3,
                        duration: 0.3,
                        ease: 'power2.out'
                    });
                });

                button.addEventListener('mouseleave', () => {
                    gsap.to(flagIcon, {
                        scale: 1,
                        duration: 0.3,
                        ease: 'power2.in'
                    });
                    gsap.to(languageText, {
                        x: 0,
                        duration: 0.3,
                        ease: 'power2.in'
                    });
                });
            }
        });

        // Animácie pre možnosti v dropdowne
        document.querySelectorAll('.language-option').forEach((option, index) => {
            option.addEventListener('mouseenter', () => {
                gsap.to(option, {
                    scale: 1.02,
                    duration: 0.2,
                    ease: 'power1.out'
                });
            });

            option.addEventListener('mouseleave', () => {
                gsap.to(option, {
                    scale: 1,
                    duration: 0.2,
                    ease: 'power1.in'
                });
            });
        });
    }, 500); // Give Alpine.js time to initialize
});
</script>
