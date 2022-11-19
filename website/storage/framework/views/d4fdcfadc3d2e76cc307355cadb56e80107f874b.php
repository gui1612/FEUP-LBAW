<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap');
    </style> 

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src=<?php echo e(asset('js/app.js')); ?> defer>
</script>
  </head>
  <body>
    <main>
      <header>
        <?php echo $__env->yieldContent('header'); ?>
        
      </header>
      <section id="content">
        <?php echo $__env->yieldContent('content'); ?>
      </section>
    </main>
  </body>
</html>
<?php /**PATH /home/marinevas/uni/LBAW/lbaw2264/website/resources/views/layouts/app.blade.php ENDPATH**/ ?>