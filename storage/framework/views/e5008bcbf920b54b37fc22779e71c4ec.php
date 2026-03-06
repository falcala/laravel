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

  
  <?php
    $navPos   = $page->nav_position ?? 'normal';
    $navClass = match($navPos) { 'sticky' => 'sticky-top', 'fixed' => 'fixed-top', default => '' };
    $navItems = $page->nav_enabled ? ($page->nav_items ?? []) : [];
  ?>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm <?php echo e($navClass); ?>" id="main-navbar">
    <div class="container">

      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="<?php echo e(route('welcome')); ?>">
        <?php if($page->logo_url): ?>
          <img src="<?php echo e($page->logo_url); ?>" alt="<?php echo e($page->title); ?>" style="max-height:36px;object-fit:contain">
        <?php else: ?>
          <?php echo e($page->title); ?>

        <?php endif; ?>
      </a>

      <?php if(count($navItems)): ?>
      <button class="navbar-toggler border-0 ms-auto me-2" type="button"
              data-bs-toggle="collapse" data-bs-target="#main-nav-collapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-nav-collapse">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!empty($item['children'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="<?php echo e($item['url'] ?: '#'); ?>"
                 role="button" data-bs-toggle="dropdown"><?php echo e($item['label']); ?></a>
              <ul class="dropdown-menu">
                <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><a class="dropdown-item" href="<?php echo e($child['url'] ?: '#'); ?>"><?php echo e($child['label']); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </li>
            <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo e($item['url'] ?: '#'); ?>"><?php echo e($item['label']); ?></a>
            </li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <?php endif; ?>

      <div class="<?php echo e(count($navItems) ? '' : 'ms-auto'); ?> d-flex gap-2">
        <?php if(auth()->guard()->check()): ?>
          <a href="<?php echo e(route('dashboard')); ?>" class="btn">
            <img src="<?php echo e(url('img/icon_login.png')); ?>" width="35px" alt="Panel de Control" title="Panel de Control">
          </a>
        <?php else: ?>
          <a href="<?php echo e(route('login')); ?>" class="btn btn-sm">
            <img src="<?php echo e(url('img/icon_login.png')); ?>" width="35px" alt="Ingresar" title="Ingresar">
          </a>
          <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm">
            <img src="<?php echo e(url('img/icon_register.png')); ?>" width="35px" alt="Registrarse" title="Registrarse">
          </a>
        <?php endif; ?>
      </div>

    </div>
  </nav>
  <?php if($navPos === 'fixed'): ?><div style="height:56px"></div><?php endif; ?>

  
  <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div <?php if($section->anchor): ?> id="<?php echo e($section->anchor); ?>" <?php endif; ?> style="scroll-margin-top:64px">
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
      <?php elseif($section->type === 'gallery'): ?>
        <?php if (isset($component)) { $__componentOriginal5a7488291156c94457f2c8c43efe87d5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a7488291156c94457f2c8c43efe87d5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.gallery','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.gallery'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a7488291156c94457f2c8c43efe87d5)): ?>
<?php $attributes = $__attributesOriginal5a7488291156c94457f2c8c43efe87d5; ?>
<?php unset($__attributesOriginal5a7488291156c94457f2c8c43efe87d5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a7488291156c94457f2c8c43efe87d5)): ?>
<?php $component = $__componentOriginal5a7488291156c94457f2c8c43efe87d5; ?>
<?php unset($__componentOriginal5a7488291156c94457f2c8c43efe87d5); ?>
<?php endif; ?>
      <?php elseif($section->type === 'testimonial'): ?>
        <?php if (isset($component)) { $__componentOriginale6af3c0f5ac34290d8f7e67920413ac7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6af3c0f5ac34290d8f7e67920413ac7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.testimonial','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.testimonial'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale6af3c0f5ac34290d8f7e67920413ac7)): ?>
<?php $attributes = $__attributesOriginale6af3c0f5ac34290d8f7e67920413ac7; ?>
<?php unset($__attributesOriginale6af3c0f5ac34290d8f7e67920413ac7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale6af3c0f5ac34290d8f7e67920413ac7)): ?>
<?php $component = $__componentOriginale6af3c0f5ac34290d8f7e67920413ac7; ?>
<?php unset($__componentOriginale6af3c0f5ac34290d8f7e67920413ac7); ?>
<?php endif; ?>
      <?php elseif($section->type === 'faq'): ?>
        <?php if (isset($component)) { $__componentOriginal871f819925592cac5093a9ea5abc64c2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal871f819925592cac5093a9ea5abc64c2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.faq','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.faq'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal871f819925592cac5093a9ea5abc64c2)): ?>
<?php $attributes = $__attributesOriginal871f819925592cac5093a9ea5abc64c2; ?>
<?php unset($__attributesOriginal871f819925592cac5093a9ea5abc64c2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal871f819925592cac5093a9ea5abc64c2)): ?>
<?php $component = $__componentOriginal871f819925592cac5093a9ea5abc64c2; ?>
<?php unset($__componentOriginal871f819925592cac5093a9ea5abc64c2); ?>
<?php endif; ?>
      <?php elseif($section->type === 'cta'): ?>
        <?php if (isset($component)) { $__componentOriginal3059bb6f234c7f6929934634de0e93cd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3059bb6f234c7f6929934634de0e93cd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.cta','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.cta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3059bb6f234c7f6929934634de0e93cd)): ?>
<?php $attributes = $__attributesOriginal3059bb6f234c7f6929934634de0e93cd; ?>
<?php unset($__attributesOriginal3059bb6f234c7f6929934634de0e93cd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3059bb6f234c7f6929934634de0e93cd)): ?>
<?php $component = $__componentOriginal3059bb6f234c7f6929934634de0e93cd; ?>
<?php unset($__componentOriginal3059bb6f234c7f6929934634de0e93cd); ?>
<?php endif; ?>
      <?php elseif($section->type === 'vcard'): ?>
        <?php if (isset($component)) { $__componentOriginal96f8753bf80d9eb92055cc6ae8789401 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal96f8753bf80d9eb92055cc6ae8789401 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sections.vcard','data' => ['section' => $section]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sections.vcard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['section' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($section)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal96f8753bf80d9eb92055cc6ae8789401)): ?>
<?php $attributes = $__attributesOriginal96f8753bf80d9eb92055cc6ae8789401; ?>
<?php unset($__attributesOriginal96f8753bf80d9eb92055cc6ae8789401); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal96f8753bf80d9eb92055cc6ae8789401)): ?>
<?php $component = $__componentOriginal96f8753bf80d9eb92055cc6ae8789401; ?>
<?php unset($__componentOriginal96f8753bf80d9eb92055cc6ae8789401); ?>
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
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  
  <footer class="bg-dark text-white text-center py-4 mt-5">
    <small>&copy; <?php echo e(date('Y')); ?> <?php echo e($page->title); ?>. All rights reserved.</small>
  </footer>

  
  <?php if($page->whatsapp): ?>
  <a href="https://wa.me/<?php echo e($page->whatsapp); ?>"
     target="_blank" rel="noopener"
     title="Escríbenos por WhatsApp"
     style="position:fixed;bottom:24px;right:24px;z-index:9999;
            width:56px;height:56px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            transition:transform .2s,box-shadow .2s;text-decoration:none"
     onmouseenter="this.style.transform='scale(1.1)';this.style.boxShadow='0 6px 22px rgba(37,211,102,.6)'"
     onmouseleave="this.style.transform='scale(1)';this.style.boxShadow='none'">
    <img src="<?php echo e(url('img/walogo.png')); ?>" alt="Whatsapp">
  </a>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\sneat\resources\views/welcome.blade.php ENDPATH**/ ?>