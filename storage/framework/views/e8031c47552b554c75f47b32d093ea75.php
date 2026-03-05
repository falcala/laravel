<?php $items = $section->content['items'] ?? []; ?>

<div id="faq-items-<?php echo e($section->id); ?>">
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="border rounded p-3 mb-3 faq-item">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <strong class="small">Q<?php echo e($i + 1); ?></strong>
    <button type="button" class="btn btn-sm btn-outline-danger remove-faq">
      <i class="bx bx-trash"></i> Remove
    </button>
  </div>
  <div class="mb-2">
    <label class="form-label small">Question</label>
    <input type="text" name="content[items][<?php echo e($i); ?>][question]"
           class="form-control form-control-sm" value="<?php echo e($item['question'] ?? ''); ?>">
  </div>
  <div>
    <label class="form-label small">Answer</label>
    <textarea name="content[items][<?php echo e($i); ?>][answer]"
              class="form-control form-control-sm" rows="2"><?php echo e($item['answer'] ?? ''); ?></textarea>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1 add-faq"
        data-section="<?php echo e($section->id); ?>">
  <i class="bx bx-plus me-1"></i> Add Question
</button>

<script>
(function () {
  var secId = '<?php echo e($section->id); ?>';
  var count = <?php echo e(count($items)); ?>;

  function bindRemove() {
    document.querySelectorAll('#faq-items-' + secId + ' .remove-faq').forEach(function (btn) {
      btn.onclick = function () { btn.closest('.faq-item').remove(); };
    });
  }
  bindRemove();

  document.querySelector('.add-faq[data-section="' + secId + '"]')
    .addEventListener('click', function () {
      var idx = count++;
      var tpl = `
        <div class="border rounded p-3 mb-3 faq-item">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="small">Q${idx + 1}</strong>
            <button type="button" class="btn btn-sm btn-outline-danger remove-faq">
              <i class="bx bx-trash"></i> Remove
            </button>
          </div>
          <div class="mb-2">
            <label class="form-label small">Question</label>
            <input type="text" name="content[items][${idx}][question]" class="form-control form-control-sm">
          </div>
          <div>
            <label class="form-label small">Answer</label>
            <textarea name="content[items][${idx}][answer]" class="form-control form-control-sm" rows="2"></textarea>
          </div>
        </div>`;
      document.getElementById('faq-items-' + secId).insertAdjacentHTML('beforeend', tpl);
      bindRemove();
    });
}());
</script><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/pages/sections/faq.blade.php ENDPATH**/ ?>