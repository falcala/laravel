

<?php $__env->startSection('title', 'Editar Permiso'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
  <div class="col-md-9">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Editar Permiso: <strong><?php echo e($role->name); ?></strong></h5></div>
      <div class="card-body">

        <?php if($errors->any()): ?>
          <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form action="<?php echo e(route('roles.update', $role)); ?>" method="POST">
          <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

          <div class="mb-3">
            <label class="form-label">Nombre del Permiso</label>
            <input type="text" name="name"
                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('name', $role->name)); ?>" />
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="mb-4">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_default"
                     id="is_default" value="1"
                     <?php echo e(old('is_default', $role->is_default) ? 'checked' : ''); ?>>
              <label class="form-check-label" for="is_default">
                Asignar como Base a nuevos registros
              </label>
            </div>
            <small class="text-muted">Solo puede estar un permiso base asignado.</small>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Permisos</label>
            <small class="text-muted d-block mb-2">
              Utilice las casillas de verificación para conceder acceso. Active o desactive una fila (módulo) o columna (acción) completa a la vez.
            </small>
            <?php echo $__env->make('content.roles._permissions_table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>

          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-secondary ms-1">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/roles/edit.blade.php ENDPATH**/ ?>