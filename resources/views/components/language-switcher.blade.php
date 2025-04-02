<div class="relative language-switcher" x-data="{ open: false }">
    <!-- Current Language Button -->
    <button @click="open = !open"
            class="language-button flex items-center space-x-2 px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 transition-colors">
        <img src="{{ asset('images/flags/' . $lang . '.svg') }}"
             alt="{{ strtoupper($lang) }}"
             class="w-5 h-5">
        <span class="language-text">{{ __('languages.' . $lang) }}</span>
        <svg class="w-4 h-4 arrow-icon"
             :class="{'rotate-180': open}"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Language Dropdown -->
    <div x-show="open"
         @click.away="open = false"
         class="language-dropdown absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-700 ring-1 ring-black ring-opacity-5 z-50">
        <div class="py-1">
            @foreach(config('app.available_languages') as $code)
                @if($code !== $lang)
                    <a href="/{{ $code }}"
                       class="language-option flex items-center space-x-3 px-4 py-2 text-sm text-gray-150 hover:bg-gray-600">
                        <img src="{{ asset('images/flags/' . $code . '.svg') }}"
                             alt="{{ strtoupper($code) }}"
                             class="w-5 h-5">
                        <span>{{ __('languages.' . $code) }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Hover animácie pre tlačidlo
    gsap.utils.toArray('.language-button').forEach(button => {
        button.addEventListener('mouseenter', () => {
            gsap.to(button.querySelector('.flag-icon'), {
                scale: 1.1,
                duration: 0.3,
                ease: 'power2.out'
            });
            gsap.to(button.querySelector('.language-text'), {
                x: 3,
                duration: 0.3,
                ease: 'power2.out'
            });
        });

        button.addEventListener('mouseleave', () => {
            gsap.to(button.querySelector('.flag-icon'), {
                scale: 1,
                duration: 0.3,
                ease: 'power2.in'
            });
            gsap.to(button.querySelector('.language-text'), {
                x: 0,
                duration: 0.3,
                ease: 'power2.in'
            });
        });
    });

    // Animácie pre možnosti v dropdowne
    gsap.utils.toArray('.language-option').forEach((option, index) => {
        gsap.set(option, { opacity: 0, x: -20 });

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

    // Animácia šípky
    const arrowTimeline = gsap.timeline({ paused: true });
    arrowTimeline.to('.arrow-icon', {
        rotation: 180,
        duration: 0.3,
        ease: 'power2.inOut'
    });

    document.querySelector('.language-button').addEventListener('click', () => {
        const isOpen = document.querySelector('.language-dropdown').style.opacity !== '0';
        if (isOpen) {
            arrowTimeline.reverse();
        } else {
            arrowTimeline.play();

            // Animácia položiek v dropdowne
            gsap.utils.toArray('.language-option').forEach((option, index) => {
                gsap.to(option, {
                    opacity: 1,
                    x: 0,
                    duration: 0.3,
                    delay: index * 0.1,
                    ease: 'power2.out'
                });
            });
        }
    });
});
</script>
