<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/app.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/bundles/bootstrap-social/bootstrap-social.css')); ?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/components.css')); ?>">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo e(('assets/css/custom.css')); ?>">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    
</head>
<body>
    <div id="app">
       

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
         <!-- General JS Scripts -->
  <script src="<?php echo e(asset('assets/js/app.min.js')); ?>"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="<?php echo e(asset('assets/js/scripts.js')); ?>"></script>
  <!-- Custom JS File -->
  <script src="<?php echo e(asset('ssets/js/custom.js')); ?>"></script>
    </div>
</body>
</html>
<?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/layouts/app.blade.php ENDPATH**/ ?>