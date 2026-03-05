

<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Usuarios</h5>
        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm">
          <i class="bx bx-plus me-1"></i> Agregar usuario
        </a>
      </div>
      <div class="card-body">

        <?php if(session('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Usuario</th>
                <th>Teléfono</th>
                <th>Cumpleaños</th>
                <th>Roles</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img src="<?php echo e($user->profile_picture_url); ?>"
                         alt="avatar" class="rounded-circle"
                         width="38" height="38"
                         style="object-fit:cover;">
                    <div>
                      <strong><?php echo e($user->name); ?></strong><br>
                      <small class="text-muted"><?php echo e($user->email); ?></small>
                    </div>
                  </div>
                </td>
                <td><?php echo e($user->phone ?? '—'); ?></td>
                <td><?php echo e($user->birthday ? $user->birthday->format('M d, Y') : '—'); ?></td>
                <td>
                  <?php $__empty_2 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                    <span class="badge bg-label-info"><?php echo e($role->name); ?></span>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                    <span class="text-muted">Invitado</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-warning me-1">
                    <i class="bx bx-edit"></i>
                  </a>
                  <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this user?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                  </form>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr><td colspan="5" class="text-center">No hay usuarios.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <?php echo e($users->links()); ?>

      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/users/index.blade.php ENDPATH**/ ?>