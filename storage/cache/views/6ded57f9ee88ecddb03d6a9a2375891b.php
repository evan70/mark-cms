<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto">
        <?php if($article->featured_image): ?>
            <img src="<?php echo e($article->featured_image); ?>" 
                 alt="<?php echo e($article->translations->first()->title); ?>" 
                 class="w-full h-64 md:h-96 object-cover rounded-lg mb-8">
        <?php endif; ?>

        <h1 class="text-4xl font-bold mb-4"><?php echo e($article->translations->first()->title); ?></h1>
        
        <div class="text-gray-400 mb-8">
            <time datetime="<?php echo e($article->published_at); ?>">
                <?php echo e(date('d.m.Y', strtotime($article->published_at))); ?>

            </time>
        </div>

        <div class="prose prose-lg prose-invert max-w-none">
            <?php echo $article->translations->first()->content; ?>

        </div>
    </article>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/evan/Desktop/slim4/mark/resources/views/articles/detail.blade.php ENDPATH**/ ?>