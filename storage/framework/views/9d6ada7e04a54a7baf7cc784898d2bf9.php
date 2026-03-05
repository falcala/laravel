<?php
$slides      = $section->content['slides']   ?? [];
$settings    = $section->content['settings'] ?? [];
$autoplay    = $settings['autoplay'] ?? true;
$speed       = (int)($settings['speed'] ?? 5000);
$showArrows  = $settings['show_arrows'] ?? true;
$showDots    = $settings['show_dots'] ?? true;
$slideHeight = (int)($settings['height'] ?? 480);
$heroId      = 'hero-'.$section->id;
?>

<div id="<?php echo e($heroId); ?>"
     class="carousel slide"
     data-bs-ride="<?php echo e($autoplay ? 'carousel' : 'false'); ?>"
     data-bs-interval="<?php echo e($speed); ?>">

<?php if($showDots && count($slides)>1): ?>
<div class="carousel-indicators">
<?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<button type="button"
        data-bs-target="#<?php echo e($heroId); ?>"
        data-bs-slide-to="<?php echo e($i); ?>"
        class="<?php echo e($i==0?'active':''); ?>"></button>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<div class="carousel-inner">

<?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php
$bgType  = $slide['bg_type'] ?? 'color';
$bgColor = $slide['bg_color'] ?? '#696cff';
$bgImage = $slide['bg_image'] ?? '';

$bgStyle = $bgType==='image'
 ? "background-image:url($bgImage);background-size:cover;background-position:center;"
 : "background-color:$bgColor;";
?>

<div class="carousel-item <?php echo e($i==0?'active':''); ?>"
     style="height:<?php echo e($slideHeight); ?>px;<?php echo e($bgStyle); ?>">

<div class="container h-100 d-flex align-items-center justify-content-center text-center">

<div>

<?php if(!empty($slide['title'])): ?>
<h1 class="fw-bold text-white mb-3">
<?php echo e($slide['title']); ?>

</h1>
<?php endif; ?>

<?php if(!empty($slide['subtitle'])): ?>
<p class="text-white mb-4">
<?php echo e($slide['subtitle']); ?>

</p>
<?php endif; ?>

<?php if(!empty($slide['button_text'])): ?>
<a href="<?php echo e($slide['button_url'] ?? '#'); ?>"
   class="btn btn-lg btn-light">
<?php echo e($slide['button_text']); ?>

</a>
<?php endif; ?>

</div>

</div>
</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

<?php if($showArrows && count($slides)>1): ?>

<button class="carousel-control-prev"
        type="button"
        data-bs-target="#<?php echo e($heroId); ?>"
        data-bs-slide="prev">

<span class="carousel-control-prev-icon"></span>

</button>

<button class="carousel-control-next"
        type="button"
        data-bs-target="#<?php echo e($heroId); ?>"
        data-bs-slide="next">

<span class="carousel-control-next-icon"></span>

</button>

<?php endif; ?>

</div><?php /**PATH C:\xampp\htdocs\sneat\resources\views/components/sections/hero.blade.php ENDPATH**/ ?>