<div class="table-responsive mb-3">
  <table class="table table-bordered text-center align-middle">
    <thead class="table-light">
      <tr>
        <th class="text-start" style="width:160px">Modulo</th>
        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <th class="text-capitalize">
            <span class="badge bg-label-<?php echo e(match($action) {
              'view'   => 'info',
              'create' => 'success',
              'edit'   => 'warning',
              'delete' => 'danger',
              default  => 'secondary'
            }); ?>"><?php echo e($action); ?></span>
          </th>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <th>Todo</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="text-start fw-semibold text-capitalize"><?php echo e($module); ?></td>
        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php $perm = "{$module}.{$action}"; ?>
          <td>
            <div class="form-check d-flex justify-content-center">
              <input class="form-check-input perm-check perm-<?php echo e($module); ?>"
                     type="checkbox"
                     name="permissions[]"
                     value="<?php echo e($perm); ?>"
                     id="perm_<?php echo e($module); ?>_<?php echo e($action); ?>"
                     <?php echo e(in_array($perm, $rolePermissions ?? old('permissions', [])) ? 'checked' : ''); ?>>
            </div>
          </td>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <td>
          
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input row-toggle"
                   type="checkbox"
                   data-module="<?php echo e($module); ?>"
                   title="Toggle all for <?php echo e($module); ?>"
                   <?php echo e(collect($actions)->every(fn($a) => in_array("{$module}.{$a}", $rolePermissions ?? old('permissions', []))) ? 'checked' : ''); ?>>
          </div>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    <tfoot>
      <tr>
        <td class="text-start fw-semibold">All Modules</td>
        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <td>
            <div class="form-check d-flex justify-content-center">
              <input class="form-check-input col-toggle"
                     type="checkbox"
                     data-action="<?php echo e($action); ?>"
                     title="Toggle all <?php echo e($action); ?>"
                     <?php echo e(collect($modules)->every(fn($m) => in_array("{$m}.{$action}", $rolePermissions ?? old('permissions', []))) ? 'checked' : ''); ?>>
            </div>
          </td>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <td>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="toggle-all" title="Toggle everything">
          </div>
        </td>
      </tr>
    </tfoot>
  </table>
</div>

<?php if (! $__env->hasRenderedOnce('f04594d4-78f8-4b4f-8945-74696dab35ab')): $__env->markAsRenderedOnce('f04594d4-78f8-4b4f-8945-74696dab35ab'); ?>
<?php $__env->startPush('page-script'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Row toggle (all actions for one module)
  document.querySelectorAll('.row-toggle').forEach(toggle => {
    toggle.addEventListener('change', () => {
      document.querySelectorAll(`.perm-${toggle.dataset.module}`)
        .forEach(cb => cb.checked = toggle.checked);
      syncColToggles();
      syncMasterToggle();
    });
  });

  // Column toggle (one action across all modules)
  document.querySelectorAll('.col-toggle').forEach(toggle => {
    toggle.addEventListener('change', () => {
      document.querySelectorAll(`input[name="permissions[]"]`)
        .forEach(cb => {
          if (cb.value.endsWith('.' + toggle.dataset.action)) {
            cb.checked = toggle.checked;
          }
        });
      syncRowToggles();
      syncMasterToggle();
    });
  });

  // Master toggle (everything)
  document.getElementById('toggle-all').addEventListener('change', function () {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = this.checked);
    document.querySelectorAll('.row-toggle').forEach(cb => cb.checked = this.checked);
    document.querySelectorAll('.col-toggle').forEach(cb => cb.checked = this.checked);
  });

  // Individual checkbox change
  document.querySelectorAll('.perm-check').forEach(cb => {
    cb.addEventListener('change', () => {
      syncRowToggles();
      syncColToggles();
      syncMasterToggle();
    });
  });

  function syncRowToggles() {
    document.querySelectorAll('.row-toggle').forEach(toggle => {
      const boxes = document.querySelectorAll(`.perm-${toggle.dataset.module}`);
      toggle.checked = [...boxes].every(b => b.checked);
    });
  }

  function syncColToggles() {
    document.querySelectorAll('.col-toggle').forEach(toggle => {
      const boxes = [...document.querySelectorAll('input[name="permissions[]"]')]
        .filter(cb => cb.value.endsWith('.' + toggle.dataset.action));
      toggle.checked = boxes.every(b => b.checked);
    });
  }

  function syncMasterToggle() {
    const all  = document.querySelectorAll('.perm-check');
    document.getElementById('toggle-all').checked = [...all].every(b => b.checked);
  }

  // Init on load
  syncRowToggles();
  syncColToggles();
  syncMasterToggle();
});
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/roles/_permissions_table.blade.php ENDPATH**/ ?>