<nav class="fixed top-0 w-full bg-transparent backdrop-blur-sm shadow-lg z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/<?php echo e($language ?? 'en'); ?>" class="text-xl font-bold">
                <?php echo e(config('app.name', 'Multilingual CMS')); ?>

            </a>

            <!-- Main Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/<?php echo e($language); ?>" class="nav-link">
                    <?php echo e(__('Home')); ?>

                </a>
                <a href="/<?php echo e($language); ?>/articles" class="nav-link">
                    <?php echo e(__('Articles')); ?>

                </a>
                <a href="/<?php echo e($language); ?>/categories" class="nav-link">
                    <?php echo e(__('Categories')); ?>

                </a>
                
                <!-- Language Switcher -->
                <?php echo $__env->make('components.language-switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden" id="mobile-menu-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-gray-900/50 backdrop-blur-sm rounded-lg mt-2">
                <a href="/<?php echo e($language); ?>" class="block px-3 py-2 rounded-md hover:bg-gray-700">
                    <?php echo e(__('Home')); ?>

                </a>
                <a href="/<?php echo e($language); ?>/articles" class="block px-3 py-2 rounded-md hover:bg-gray-700">
                    <?php echo e(__('Articles')); ?>

                </a>
                <?php echo $__env->make('components.language-switcher', ['isMobile' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</nav>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/evan/Desktop/slim4/mark/resources/views/components/navigation.blade.php ENDPATH**/ ?>