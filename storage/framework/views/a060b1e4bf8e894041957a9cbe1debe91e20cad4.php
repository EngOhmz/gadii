<!DOCTYPE html>
<html lang="en">


<!-- auth-register.html  21 Nov 2019 04:05:01 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <?php
$settings= App\Models\System::first();
?>
  <title><?php echo e(!empty($settings->name) ? $settings->name: ''); ?></title>
  <!-- General CSS Files -->
  <link rel='shortcut icon' type='image/x-icon' href="<?php echo e(url('public/assets/img/logo')); ?>/<?php echo e($settings->picture); ?>" />
  <link rel="stylesheet" href="<?php echo e(url('assets/css/app.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(url('assets/bundles/jquery-selectric/selectric.css')); ?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo e(url('assets/css/style.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(url('assets/css/components.css')); ?>">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo e(url('assets/css/custom.css')); ?>">

</head>

<body>
  <div class="loader"></div>
  <div id="app">
  <?php echo $__env->yieldContent('contents'); ?>
  </div>
  <!-- General JS Scripts -->
  <script src="<?php echo e(url('assets/js/app.min.js')); ?>"></script>
  <!-- JS Libraies -->
  <script src="<?php echo e(url('assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js')); ?>"></script>
  <script src="<?php echo e(url('assets/bundles/jquery-selectric/jquery.selectric.min.js')); ?>"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo e(url('assets/js/page/auth-register.js')); ?>"></script>
  <!-- Template JS File -->
  <script src="<?php echo e(url('assets/js/scripts.js')); ?>"></script>
  <!-- Custom JS File -->
  <script src="<?php echo e(url('assets/js/custom.js')); ?>"></script>
</body>


<!-- auth-register.html  21 Nov 2019 04:05:02 GMT -->
</html><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/layouts/main2.blade.php ENDPATH**/ ?>