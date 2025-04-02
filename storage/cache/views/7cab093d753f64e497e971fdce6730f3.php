<!DOCTYPE html>
<html lang="<?php echo e($language); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title ?? config('app.name')); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon-16x16.png')); ?>">
    
    <!-- Replace CDN Tailwind with local version -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <!-- Navigation -->
    <?php echo $__env->make('components.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <!-- Footer -->
    <?php echo $__env->make('components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        // Initialize GSAP
        gsap.registerPlugin(ScrollTrigger);
        
        document.addEventListener('DOMContentLoaded', () => {
            // Základné animácie pri načítaní stránky
            const pageLoadTimeline = gsap.timeline();
            
            pageLoadTimeline
                .from('nav', {
                    y: -100,
                    opacity: 0,
                    duration: 1,
                    ease: 'power3.out'
                })
                .from('main', {
                    opacity: 0,
                    y: 30,
                    duration: 1,
                    ease: 'power2.out'
                }, '-=0.5');

            // Univerzálne animácie pre všetky stránky
            const animateElements = {
                fadeIn: {
                    opacity: 0,
                    y: 30,
                    duration: 0.7
                },
                slideUp: {
                    opacity: 0,
                    y: 50,
                    duration: 0.7
                },
                slideRight: {
                    opacity: 0,
                    x: -50,
                    duration: 0.7
                },
                slideLeft: {
                    opacity: 0,
                    x: 50,
                    duration: 0.7
                }
            };

            // Aplikovanie animácií na elementy s data-animation atribútom
            document.querySelectorAll('[data-animation]').forEach(element => {
                const animation = element.dataset.animation;
                const delay = element.dataset.delay || 0;

                if (animateElements[animation]) {
                    ScrollTrigger.create({
                        trigger: element,
                        start: "top bottom-=100px",
                        onEnter: () => {
                            gsap.from(element, {
                                ...animateElements[animation],
                                delay: parseFloat(delay)
                            });
                        }
                    });
                }
            });

            // Animácia pre obrázky
            document.querySelectorAll('img').forEach(img => {
                ScrollTrigger.create({
                    trigger: img,
                    start: "top bottom-=100px",
                    onEnter: () => {
                        gsap.from(img, {
                            scale: 0.8,
                            opacity: 0,
                            duration: 0.7,
                            ease: 'power2.out'
                        });
                    }
                });
            });

            // Animácia pre nadpisy
            document.querySelectorAll('h1, h2, h3').forEach(heading => {
                if (!heading.hasAttribute('data-animation')) {  // Ak nemá vlastnú animáciu
                    ScrollTrigger.create({
                        trigger: heading,
                        start: "top bottom-=100px",
                        onEnter: () => {
                            gsap.from(heading, {
                                y: 30,
                                opacity: 0,
                                duration: 0.7,
                                ease: 'power2.out'
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH /home/evan/Desktop/slim4/mark/resources/views/layouts/main.blade.php ENDPATH**/ ?>