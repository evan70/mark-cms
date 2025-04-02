<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-2"><?php echo e($translation->name); ?></h1>
    
    <?php if($translation->description): ?>
        <p class="text-gray-400 mb-8"><?php echo e($translation->description); ?></p>
    <?php endif; ?>
    
    <h2 class="text-2xl font-bold mb-6"><?php echo e(__('Articles in this category')); ?></h2>
    
    <?php if(count($category->articles) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $category->articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $articleTranslation = $article->translations->first();
                    if (!$articleTranslation) continue;
                ?>
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
                    <?php if($article->featured_image): ?>
                        <img src="<?php echo e(str_starts_with($article->featured_image, '/uploads/') 
                            ? $article->featured_image 
                            : '/uploads/' . $article->featured_image); ?>" 
                             alt="<?php echo e($articleTranslation->title); ?>"
                             class="w-full h-48 object-cover">
                    <?php endif; ?>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-100">
                            <?php echo e($articleTranslation->title); ?>

                        </h3>
                        <?php if($articleTranslation->perex): ?>
                            <p class="text-gray-400 mb-4">
                                <?php echo e($articleTranslation->perex); ?>

                            </p>
                        <?php endif; ?>
                        <div class="flex justify-between items-center">
                            <a href="/<?php echo e($language); ?>/articles/<?php echo e($article->slug); ?>" 
                               class="text-blue-400 hover:text-blue-300">
                                <?php echo e(__('Read More')); ?> →
                            </a>
                            <span class="text-sm text-gray-500">
                                <?php echo e(date('d.m.Y', strtotime($article->published_at))); ?>

                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p class="text-gray-400"><?php echo e(__('No articles in this category.')); ?></p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/evan/Desktop/slim4/mark/resources/views/categories/detail.blade.php ENDPATH**/ ?>