// Initialize GSAP
gsap.registerPlugin(ScrollTrigger);

// Animation presets
const animations = {
    fade: {
        opacity: 0,
        duration: 1
    },
    slideUp: {
        opacity: 0,
        y: 100,
        duration: 1
    },
    slideRight: {
        opacity: 0,
        x: -100,
        duration: 1
    },
    slideLeft: {
        opacity: 0,
        x: 100,
        duration: 1
    },
    scale: {
        opacity: 0,
        scale: 0.5,
        duration: 1
    }
};

// Background animation
const createAnimatedBackground = () => {
    // Najprv skontrolujeme či už background neexistuje
    if (!document.querySelector('.animated-bg')) {
        const bg = document.createElement('div');
        bg.className = 'animated-bg';
        document.body.insertBefore(bg, document.body.firstChild);
        
        // Vytvoríme pseudo elementy programaticky
        const before = document.createElement('div');
        before.className = 'animated-bg-before';
        const after = document.createElement('div');
        after.className = 'animated-bg-after';
        
        bg.appendChild(before);
        bg.appendChild(after);
        
        console.log('Animated background created'); // Pre debugovanie
    }
};

// Initialize animations when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded'); // Pre debugovanie
    createAnimatedBackground();
});

// Export for use in other files
window.pageAnimations = {
    init: createAnimatedBackground
};
