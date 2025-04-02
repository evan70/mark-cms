<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8"><?php echo e(__('Categories')); ?></h1>
    
    <?php if(count($categories) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $translation = $category->translations->first();
                    if (!$translation) continue;
                ?>
                <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg border border-gray-700">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2 text-gray-100">
                            <?php echo e($translation->name); ?>

                        </h2>
                        <?php if($translation->description): ?>
                            <p class="text-gray-400 mb-4">
                                <?php echo e($translation->description); ?>

                            </p>
                        <?php endif; ?>
                        <a href="<?php echo e($baseUrl); ?>/<?php echo e($language); ?>/categories/<?php echo e($category->slug); ?>"
                           class="text-blue-400 hover:text-blue-300">
                            <?php echo e(__('View Category')); ?> →
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p class="text-gray-400 text-center"><?php echo e(__('No categories found.')); ?></p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/evan/Desktop/slim4/mark/resources/views/categories/list.blade.php ENDPATH**/ ?>