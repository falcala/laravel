<?php
	$items = $section->content['items'] ?? [];
	$cols  = 12 / ($section->content['columns'] ?? 3);
?>
<section class="py-5">
	<div class="container">
		<h2 class="text-center fw-bold mb-5"><?php echo e($section->title); ?></h2>
		<div class="row g-4">
		<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="col-md-<?php echo e($cols); ?>">
			<div class="text-center p-4 h-100 border rounded shadow-sm">
				<div class="feature-icon mx-auto mb-3">
					<i class="bx <?php echo e($item['icon'] ?? 'bx-star'); ?> fs-2 text-primary"></i>
				</div>
				<h5 class="fw-bold"><?php echo e($item['title'] ?? ''); ?></h5>
				<p class="text-muted mb-0"><?php echo e($item['description'] ?? ''); ?></p>
			</div>
		</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
</section><?php /**PATH C:\xampp\htdocs\sneat\resources\views/components/sections/features.blade.php ENDPATH**/ ?>