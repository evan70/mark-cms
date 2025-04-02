<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8"><?php echo e(__('Articles')); ?></h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $translation = $article->translations->first();
            ?>
            <?php if($translation): ?>
            <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                <?php if($article->featured_image): ?>
                    <img src="<?php echo e($article->featured_image); ?>" alt="<?php echo e($translation->title); ?>" class="w-full h-48 object-cover">
                <?php endif; ?>
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2"><?php echo e($translation->title); ?></h2>
                    <p class="text-gray-400 mb-4"><?php echo e(str_limit($translation->perex, 150)); ?></p>
                    <a href="/<?php echo e($language); ?>/article/<?php echo e($article->slug); ?>" 
                       class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition-colors">
                        <?php echo e(__('Read More')); ?>

                    </a>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/evan/Desktop/slim4/mark/resources/views/articles/index.blade.php ENDPATH**/ ?>