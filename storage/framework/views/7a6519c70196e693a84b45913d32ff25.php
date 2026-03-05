<?php $plans = $section->content['plans'] ?? []; ?>

<div class="mb-3">
  <label class="form-label small">Columns</label>
  <select name="content[columns]" class="form-select form-select-sm">
    <?php $__currentLoopData = [2,3,4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($col); ?>" <?php echo e(($section->content['columns'] ?? 3) == $col ? 'selected' : ''); ?>>
        <?php echo e($col); ?> Columns
      </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>

<div id="pricing-plans">
  <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="border rounded p-3 mb-2 plan-item <?php echo e(($plan['highlighted'] ?? false) ? 'border-primary' : ''); ?>">
    <div class="d-flex justify-content-between mb-2">
      <strong>Plan <?php echo e($i + 1); ?></strong>
      <button type="button" class="btn btn-sm btn-outline-danger remove-plan"><i class="bx bx-trash"></i></button>
    </div>
    <div class="row g-2">
      <div class="col-6">
        <label class="form-label small">Plan Name</label>
        <input type="text" name="content[plans][<?php echo e($i); ?>][name]"
               class="form-control form-control-sm" value="<?php echo e($plan['name'] ?? ''); ?>" />
      </div>
      <div class="col-3">
        <label class="form-label small">Price</label>
        <input type="text" name="content[plans][<?php echo e($i); ?>][price]"
               class="form-control form-control-sm" value="<?php echo e($plan['price'] ?? '0'); ?>" />
      </div>
      <div class="col-3">
        <label class="form-label small">Period</label>
        <input type="text" name="content[plans][<?php echo e($i); ?>][period]"
               class="form-control form-control-sm" value="<?php echo e($plan['period'] ?? 'mo'); ?>" />
      </div>
      <div class="col-8">
        <label class="form-label small">Button Text</label>
        <input type="text" name="content[plans][<?php echo e($i); ?>][button_text]"
               class="form-control form-control-sm" value="<?php echo e($plan['button_text'] ?? 'Get Started'); ?>" />
      </div>
      <div class="col-4 d-flex align-items-end pb-1">
        <div class="form-check">
          <input class="form-check-input" type="checkbox"
                 name="content[plans][<?php echo e($i); ?>][highlighted]" value="1"
                 <?php echo e(($plan['highlighted'] ?? false) ? 'checked' : ''); ?>>
          <label class="form-check-label small">Highlight</label>
        </div>
      </div>
      <div class="col-12">
        <label class="form-label small">Features (one per line)</label>
        <textarea name="content[plans][<?php echo e($i); ?>][features_text]"
                  class="form-control form-control-sm" rows="3"><?php echo e(implode("\n", $plan['features'] ?? [])); ?></textarea>
      </div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1" id="add-plan">
  <i class="bx bx-plus me-1"></i> Add Plan
</button>

<script>
(function() {
  let count = <?php echo e(count($plans)); ?>;
  document.getElementById('add-plan').addEventListener('click', () => {
    const tpl = `<div class="border rounded p-3 mb-2 plan-item">
      <div class="d-flex justify-content-between mb-2">
        <strong>Plan ${count + 1}</strong>
        <button type="button" class="btn btn-sm btn-outline-danger remove-plan"><i class="bx bx-trash"></i></button>
      </div>
      <div class="row g-2">
        <div class="col-6"><label class="form-label small">Plan Name</label>
          <input type="text" name="content[plans][${count}][name]" class="form-control form-control-sm" /></div>
        <div class="col-3"><label class="form-label small">Price</label>
          <input type="text" name="content[plans][${count}][price]" class="form-control form-control-sm" value="0" /></div>
        <div class="col-3"><label class="form-label small">Period</label>
          <input type="text" name="content[plans][${count}][period]" class="form-control form-control-sm" value="mo" /></div>
        <div class="col-8"><label class="form-label small">Button Text</label>
          <input type="text" name="content[plans][${count}][button_text]" class="form-control form-control-sm" value="Get Started" /></div>
        <div class="col-4 d-flex align-items-end pb-1">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="content[plans][${count}][highlighted]" value="1">
            <label class="form-check-label small">Highlight</label>
          </div>
        </div>
        <div class="col-12"><label class="form-label small">Features (one per line)</label>
          <textarea name="content[plans][${count}][features_text]" class="form-control form-control-sm" rows="3"></textarea></div>
      </div></div>`;
    document.getElementById('pricing-plans').insertAdjacentHTML('beforeend', tpl);
    count++;
    bindRemove();
  });
  function bindRemove() {
    document.querySelectorAll('.remove-plan').forEach(b => b.onclick = () => b.closest('.plan-item').remove());
  }
  bindRemove();
})();
</script><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/pages/sections/pricing.blade.php ENDPATH**/ ?>