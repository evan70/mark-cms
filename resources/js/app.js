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

    // Set initial states
    animatedElements.forEach(element => {
        const animation = element.dataset.animation;
        if (animation === "fadeIn") {
            gsap.set(element, { opacity: 0, y: 30 });
        } else if (animation === "slideUp") {
            gsap.set(element, { opacity: 0, y: 50 });
        }
    });

    // Create ScrollTriggers
    animatedElements.forEach(element => {
        const animation = element.dataset.animation;
        const delay = element.dataset.delay || 0;

        ScrollTrigger.create({
            trigger: element,
            start: "top bottom-=100px",
            onEnter: () => {
                if (animation === "fadeIn") {
                    gsap.to(element, {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        delay: parseFloat(delay)
                    });
                } else if (animation === "slideUp") {
                    gsap.to(element, {
                        opacity: 1,
                        y: 0,
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
