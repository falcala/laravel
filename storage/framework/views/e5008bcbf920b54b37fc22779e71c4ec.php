<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  
  <title><?php echo e($page->seo_title ?: $page->title); ?></title>
  <meta name="description"
        content="<?php echo e($page->seo_description ?: $page->meta_description); ?>">
  <?php if($page->seo_keywords): ?>
  <meta name="keywords" content="<?php echo e($page->seo_keywords); ?>">
  <?php endif; ?>
  <?php if($page->canonical_url): ?>
  <link rel="canonical" href="<?php echo e($page->canonical_url); ?>">
  <?php endif; ?>

  
  <meta property="og:type"        content="website">
  <meta property="og:url"         content="<?php echo e($page->canonical_url ?: url('/')); ?>">
  <meta property="og:title"       content="<?php echo e($page->og_title ?: $page->seo_title ?: $page->title); ?>">
  <meta property="og:description" content="<?php echo e($page->og_description ?: $page->seo_description ?: $page->meta_description); ?>">
  <?php if($page->og_image_url): ?>
  <meta property="og:image"       content="<?php echo e($page->og_image_url); ?>">
  <?php endif; ?>

  
  <meta name="twitter:card"  content="<?php echo e($page->twitter_card ?? 'summary_large_image'); ?>">
  <?php if($page->twitter_site): ?>
  <meta name="twitter:site"  content="{{ ltrim($page->twitter_site, '@') }}">
  <?php endif; ?>
  <meta name="twitter:title" content="<?php echo e($page->og_title ?: $page->seo_title ?: $page->title); ?>">
  <meta name="twitter:description"
        content="<?php echo e($page->og_description ?: $page->seo_description ?: $page->meta_description); ?>">
  <?php if($page->og_image_url): ?>
  <meta name="twitter:image" content="<?php echo e($page->og_image_url); ?>">
  <?php endif; ?>

  
  <?php if($page->favicon_url): ?>
  <link rel="icon" href="<?php echo e($page->favicon_url); ?>">
  <?php endif; ?>

  
  <?php if($page->schema_markup): ?>
  <script type="application/ld+json">
    <?php echo json_encode($page->schema_markup, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>

  </script>
  <?php endif; ?>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <style>
    .hero-slide { min-height: 480px; display:flex; align-items:center; }
    .pricing-card.highlighted { border: 2px solid #696cff; transform: scale(1.05); }
    .feature-icon { width:56px; height:56px; border-radius:12px; display:flex; align-items:center; justify-content:center; background:rgba(105,108,255,.1); }
  </style>
</head>
<body>

  
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	  <div class="container">
		<a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?php echo e(route('welcome')); ?>">
		  <?php if($page->logo_url): ?>
			<img src="<?php echo e($page->logo_url); ?>" alt="<?php echo e($page->title); ?>"
				 style="max-height:36px; object-fit:contain">
		  <?php else: ?>
			<?php echo e($page->title); ?>

		  <?php endif; ?>
		</a>
		<div class="ms-auto d-flex gap-2">
		  <?php if(auth()->guard()->check()): ?>
			<a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-primary btn-sm">Dashboard</a>
		  <?php else: ?>
			<a href="<?php echo e(route('login')); ?>"    class="btn btn-outline-primary btn-sm">Login</a>
			<a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm">Register</a>
		  <?php endif; ?>
		</div>
	  </div>
	</nav>

  
	<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

	  <?php if($section->type === 'hero'): ?>
		  <?php if (isset($component)) { $__componentOriginal7d77bb759cf09fb7609ab7d50dcb0764 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d77bb759cf09fb7609ab7d50dcb0764 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.hero','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d77bb759cf09fb7609ab7d50dcb0764)): ?>
<?php $attributes = $__attributesOriginal7d77bb759cf09fb7609ab7d50dcb0764; ?>
<?php unset($__attributesOriginal7d77bb759cf09fb7609ab7d50dcb0764); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d77bb759cf09fb7609ab7d50dcb0764)): ?>
<?php $component = $__componentOriginal7d77bb759cf09fb7609ab7d50dcb0764; ?>
<?php unset($__componentOriginal7d77bb759cf09fb7609ab7d50dcb0764); ?>
<?php endif; ?>

	  <?php elseif($section->type === 'features'): ?>
		  <?php if (isset($component)) { $__componentOriginal6ba66857502b2c621a48ed5da8100e7b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ba66857502b2c621a48ed5da8100e7b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.features','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.features'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6ba66857502b2c621a48ed5da8100e7b)): ?>
<?php $attributes = $__attributesOriginal6ba66857502b2c621a48ed5da8100e7b; ?>
<?php unset($__attributesOriginal6ba66857502b2c621a48ed5da8100e7b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ba66857502b2c621a48ed5da8100e7b)): ?>
<?php $component = $__componentOriginal6ba66857502b2c621a48ed5da8100e7b; ?>
<?php unset($__componentOriginal6ba66857502b2c621a48ed5da8100e7b); ?>
<?php endif; ?>

	  <?php elseif($section->type === 'pricing'): ?>
		  <?php if (isset($component)) { $__componentOriginal67958b40bb9729ac877d83f1bb8ebdcf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal67958b40bb9729ac877d83f1bb8ebdcf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.pricing','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.pricing'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal67958b40bb9729ac877d83f1bb8ebdcf)): ?>
<?php $attributes = $__attributesOriginal67958b40bb9729ac877d83f1bb8ebdcf; ?>
<?php unset($__attributesOriginal67958b40bb9729ac877d83f1bb8ebdcf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal67958b40bb9729ac877d83f1bb8ebdcf)): ?>
<?php $component = $__componentOriginal67958b40bb9729ac877d83f1bb8ebdcf; ?>
<?php unset($__componentOriginal67958b40bb9729ac877d83f1bb8ebdcf); ?>
<?php endif; ?>

	  <?php elseif($section->type === 'calendar'): ?>
		  <?php if (isset($component)) { $__componentOriginal1c703606fa297b24cfb1959e42f19235 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c703606fa297b24cfb1959e42f19235 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.calendar','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c703606fa297b24cfb1959e42f19235)): ?>
<?php $attributes = $__attributesOriginal1c703606fa297b24cfb1959e42f19235; ?>
<?php unset($__attributesOriginal1c703606fa297b24cfb1959e42f19235); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c703606fa297b24cfb1959e42f19235)): ?>
<?php $component = $__componentOriginal1c703606fa297b24cfb1959e42f19235; ?>
<?php unset($__componentOriginal1c703606fa297b24cfb1959e42f19235); ?>
<?php endif; ?>

	  <?php elseif($section->type === 'custom'): ?>
		  <?php if (isset($component)) { $__componentOriginal22c0545a2b13b20cda15f20b8aa61550 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal22c0545a2b13b20cda15f20b8aa61550 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.custom','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.custom'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal22c0545a2b13b20cda15f20b8aa61550)): ?>
<?php $attributes = $__attributesOriginal22c0545a2b13b20cda15f20b8aa61550; ?>
<?php unset($__attributesOriginal22c0545a2b13b20cda15f20b8aa61550); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal22c0545a2b13b20cda15f20b8aa61550)): ?>
<?php $component = $__componentOriginal22c0545a2b13b20cda15f20b8aa61550; ?>
<?php unset($__componentOriginal22c0545a2b13b20cda15f20b8aa61550); ?>
<?php endif; ?>

	  <?php endif; ?>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  
  <footer class="bg-dark text-white text-center py-4 mt-5">
    <small>&copy; <?php echo e(date('Y')); ?> <?php echo e($page->title); ?>. All rights reserved.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\sneat\resources\views/welcome.blade.php ENDPATH**/ ?>