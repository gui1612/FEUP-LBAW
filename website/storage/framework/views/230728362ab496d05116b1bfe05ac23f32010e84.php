<?php $__env->startSection('header'); ?>
  <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', $post->title); ?>

<?php $__env->startSection('content'); ?>
<body>
    <form class="post">
      <div class="post_content">
        <div class="editable_title">
          <label>Title: </label>
          <span class="edit_title" contenteditable="true">
            <?php echo e($post->title); ?>

          </span>
        </div>

        <div class="editable_body">
          <label hidden>body</label>        
          <p class="edit_body" contenteditable="true">
            <?php echo e($post->body); ?>

          </p>
        </div>

        <div class="post_images">
          <?php $__currentLoopData = $post->images()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="font-light"><?php echo e($img->path); ?></span>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <button class="edit_button">
          <span>add image</span>
          <img src= <?php echo e(asset('images/icons/plus.svg')); ?> alt="add an embed" width="20" height="20">
        </button>

        <button class="edit_button">Save Changes</button>
        <a href="<?php echo e(route('post', ['id'=>$id])); ?>" class="edit_button">Cancel</a>
        <button class="edit_button bg-red-500" >Delete Post</button>
      </div>
    </form>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/edit_post.blade.php ENDPATH**/ ?>