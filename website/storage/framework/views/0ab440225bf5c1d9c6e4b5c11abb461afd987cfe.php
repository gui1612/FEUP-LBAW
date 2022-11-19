<?php $__env->startSection('header'); ?>
  <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', $post->title); ?>

<?php $__env->startSection('content'); ?>
<body>
    <article class="post">
        <section class="post_content"> 
            <h2> <?php echo e($post->title); ?> </h2>
            <p> <?php echo e($post->body); ?> </p>

            <a> 
                <img src= <?php echo e(asset('images/logo.svg')); ?> alt="" width="20" height="20">
                <?php echo e($post->owner_id); ?> 
            </a>

            <span> on <?php echo e($post->created_at); ?> </span>
            
            <div class="post_content_rating">
                <button> 
                    <img src= <?php echo e(asset('images/icons/like.svg')); ?> alt="Like this post">
                </button>
                <?php echo e($post->rating); ?> 
                <button> 
                    <img src= <?php echo e(asset('images/icons/dislike.svg')); ?> alt="Dislike this post">
                </button>
            </div>
        </section>
    </article>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marinevas/uni/LBAW/lbaw2264/website/resources/views/pages/post.blade.php ENDPATH**/ ?>