<!DOCTYPE html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="<?php echo e(asset('/assets') . '/'); ?>" dir="ltr" data-skin="default" data-base-url="<?php echo e(url('/')); ?>" data-framework="laravel" data-bs-theme="light" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>
        <?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('variables.templateName') ? config('variables.templateName') : 'TemplateName'); ?>

        - <?php echo e(config('variables.templateSuffix') ? config('variables.templateSuffix') : 'TemplateSuffix'); ?>

    </title>
    <meta name="description" content="<?php echo e(config('variables.templateDescription') ? config('variables.templateDescription') : ''); ?>" />
    <meta name="keywords" content="<?php echo e(config('variables.templateKeyword') ? config('variables.templateKeyword') : ''); ?>" />
    <meta property="og:title" content="<?php echo e(config('variables.ogTitle') ? config('variables.ogTitle') : ''); ?>" />
    <meta property="og:type" content="<?php echo e(config('variables.ogType') ? config('variables.ogType') : ''); ?>" />
    <meta property="og:url" content="<?php echo e(config('variables.productPage') ? config('variables.productPage') : ''); ?>" />
    <meta property="og:image" content="<?php echo e(config('variables.ogImage') ? config('variables.ogImage') : ''); ?>" />
    <meta property="og:description" content="<?php echo e(config('variables.templateDescription') ? config('variables.templateDescription') : ''); ?>" />
    <meta property="og:site_name" content="<?php echo e(config('variables.creatorName') ? config('variables.creatorName') : ''); ?>" />
    <meta name="robots" content="noindex, nofollow" />
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <!-- Canonical SEO -->
    <link rel="canonical" href="<?php echo e(config('variables.productPage') ? config('variables.productPage') : ''); ?>" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon/favicon.ico')); ?>" />

    <!-- Include Styles -->
    <?php echo $__env->make('layouts/sections/styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Include Scripts for customizer, helper, analytics, config -->
    <?php echo $__env->make('layouts/sections/scriptsIncludes', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>
    <!-- Layout Content -->
    <?php echo $__env->yieldContent('layoutContent'); ?>
    <!--/ Layout Content -->

    

    <!-- Include Scripts -->
    <?php echo $__env->make('layouts/sections/scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\sneat\resources\views/layouts/commonMaster.blade.php ENDPATH**/ ?>