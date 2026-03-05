<?php
	$plans = $section->content['plans'] ?? [];
	$cols  = 12 / ($section->content['columns'] ?? 3);
?>
<section class="py-5 bg-light">
  <div class="container">
	<h2 class="text-center fw-bold mb-5"><?php echo e($section->title); ?></h2>
	<div class="row g-4 justify-content-center align-items-center">
	  <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  <div class="col-md-<?php echo e($cols); ?>">
		<div class="card h-100 pricing-card <?php echo e(($plan['highlighted'] ?? false) ? 'highlighted' : ''); ?>">
		  <div class="card-body text-center p-4">
			<h5 class="fw-bold mb-3"><?php echo e($plan['name'] ?? ''); ?></h5>
			<div class="display-5 fw-bold text-primary mb-1">
			  $<?php echo e($plan['price'] ?? '0'); ?>

			</div>
			<small class="text-muted">/ <?php echo e($plan['period'] ?? 'mo'); ?></small>
			<ul class="list-unstyled mt-4 mb-4">
			  <?php $__currentLoopData = $plan['features'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			  <li class="py-1 border-bottom">
				<i class="bx bx-check text-success me-1"></i><?php echo e($feature); ?>

			  </li>
			  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
			<a href="<?php echo e(route('register')); ?>"
			   class="btn w-100 <?php echo e(($plan['highlighted'] ?? false) ? 'btn-primary' : 'btn-outline-primary'); ?>">
			  <?php echo e($plan['button_text'] ?? 'Get Started'); ?>

			</a>
		  </div>
		</div>
	  </div>
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
  </div>
</section><?php /**PATH C:\xampp\htdocs\sneat\resources\views/components/sections/pricing.blade.php ENDPATH**/ ?>