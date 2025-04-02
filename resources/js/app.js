import { initNavigation } from './navigation';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Default animation settings
gsap.defaults({
    ease: "power2.out",
    duration: 0.7
});

// Global animation effects
gsap.registerEffect({
    name: "fadeIn",
    effect: (targets, config) => {
        return gsap.from(targets, {
            opacity: 0,
            y: 30,
            duration: config.duration || 0.7,
            stagger: config.stagger || 0.2
        });
    }
});

gsap.registerEffect({
    name: "slideUp",
    effect: (targets, config) => {
        return gsap.from(targets, {
            opacity: 0,
            y: 50,
            duration: config.duration || 0.7
        });
    }
});

// Initialize animations
function initAnimations() {
    // Find all elements with data-animation attribute
    const animatedElements = document.querySelectorAll('[data-animation]');
    
    animatedElements.forEach(element => {
        const animation = element.dataset.animation;
        const delay = element.dataset.delay || 0;
        
        // Create ScrollTrigger for each element
        ScrollTrigger.create({
            trigger: element,
            start: "top bottom-=100px",
            onEnter: () => {
                // Use direct GSAP animation instead of effects
                if (animation === "fadeIn") {
                    gsap.from(element, {
                        opacity: 0,
                        y: 30,
                        duration: 0.7,
                        delay: parseFloat(delay)
                    });
                } else if (animation === "slideUp") {
                    gsap.from(element, {
                        opacity: 0,
                        y: 50,
                        duration: 0.7,
                        delay: parseFloat(delay)
                    });
                }
            }
        });
    });
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initAnimations();
});
