

<?php $__env->startSection('title', 'Permisos'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Roles</h5>
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.create')): ?>
        <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary btn-sm">
          <i class="bx bx-plus me-1"></i> Agregar Role
        </a>
		<?php endif; ?>
      </div>
      <div class="card-body">

        <?php if(session('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
				<th>#</th>
				<th>Permiso</th>
				<th>Base</th>
				<th>Usuarios</th>
				<th>Permisos</th>
				<th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
				<td><?php echo e($role->id); ?></td>
                <td><span class="badge bg-label-primary"><?php echo e($role->name); ?></span></td>
				<td>
				  <?php if($role->is_default): ?>
					<span class="badge bg-success">Base</span>
				  <?php else: ?>
					<span class="text-muted">—</span>
				  <?php endif; ?>
				</td>
                <td><?php echo e($role->users_count); ?></td>
				<td>
                  <?php
                    $modules = collect($role->permissions->pluck('name'))
                        ->groupBy(fn($p) => explode('.', $p)[0])
                        ->map(fn($perms, $module) => [
                            'module'  => $module,
                            'actions' => $perms->map(fn($p) => explode('.', $p)[1])->values()
                        ]);
                  ?>
                  <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-center gap-1 mb-1">
                      <span class="badge bg-label-dark text-capitalize" style="min-width:60px"><?php echo e($m['module']); ?></span>
                      <?php $__currentLoopData = $m['actions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-label-<?php echo e(match($action) {
                          'view'   => 'info',
                          'create' => 'success',
                          'edit'   => 'warning',
                          'delete' => 'danger',
                          default  => 'secondary'
                        }); ?>"><?php echo e($action); ?></span>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php if($modules->isEmpty()): ?>
                    <span class="text-muted">Sin permisos</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.edit')): ?>
                    <a href="<?php echo e(route('roles.edit', $role)); ?>" class="btn btn-sm btn-warning me-1">
                      <i class="bx bx-edit"></i>
                    </a>
                  <?php endif; ?>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.delete')): ?>
                    <form action="<?php echo e(route('roles.destroy', $role)); ?>" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this role?')">
                      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                      <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr><td colspan="4" class="text-center">No hay permisos.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <?php echo e($roles->links()); ?>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/roles/index.blade.php ENDPATH**/ ?>