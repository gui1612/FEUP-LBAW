<?php $__env->startSection('header'); ?>
  <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', $post->title); ?>

<?php $__env->startSection('content'); ?>
<body>
    <article class="post">
        <section class="post_content"> 
            <div class="post_content_utils">
                <a class="post_content_creator_details" href=""> 
                    <img src="<?php echo e($post->owner()->first()->profile_picture ?? asset('images/default.png')); ?>" alt="<?php echo e($post->owner()->first()->username); ?>" width="20" height="20" class="rounded-full m-4">
                    <?php echo e($post->owner()->first()->username); ?> 
                </a>
                <a href="<?php echo e(route('post.edit', ['id'=>$id])); ?>"> 
                    <img src= <?php echo e(asset('images/icons/edit.svg')); ?> alt="Edit post" height="20" width="20">
                </a>
            </div>

            <h2> <?php echo e($post->title); ?> </h2>
            <p> <?php echo e($post->body); ?> </p>

            <div class="flex gap-3">
                <?php $__currentLoopData = $post->images()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="w-1/3 h-full aspect-square flex items-center">
                        <img src= "<?php echo e($img->path); ?>" alt= "<?php echo e($img->caption); ?>" class="h-full w-full object-contain">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <span> <?php echo e($post->createdAt); ?> </span>
            
            <div class="post_content_rating">
                <button> 
                    <img src= <?php echo e(asset('images/icons/like.svg')); ?> alt="Like this post" height="20" width="20">
                </button>
                <?php echo e($post->rating); ?> 
                <button> 
                    <img src= <?php echo e(asset('images/icons/dislike.svg')); ?> alt="Dislike this post" height="20" width="20">
                </button>
            </div>
        </section>
    </article>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/post.blade.php ENDPATH**/ ?>