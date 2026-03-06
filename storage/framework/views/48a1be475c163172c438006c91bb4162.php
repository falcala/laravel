

<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show mb-4">
  <?php echo e(session('success')); ?>

  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card">

  
  <div class="card-header d-flex flex-wrap align-items-center gap-3">
    <div class="flex-grow-1">
      <h5 class="mb-0"><i class="bx bx-group me-2 text-primary"></i>Usuarios</h5>
      <small class="text-muted"><?php echo e($users->total()); ?> usuarios registrados</small>
    </div>
    <button type="button" class="btn btn-primary btn-sm"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
      <i class="bx bx-plus me-1"></i> Agregar usuario
    </button>
  </div>

  
  <div class="card-body border-bottom pb-3">
    <form method="GET" action="<?php echo e(route('users.index')); ?>" id="filter-form" class="row g-3 align-items-end">

      
      <div class="col-md-5">
        <label class="form-label small fw-semibold">Buscar</label>
        <div class="input-group input-group-sm">
          <span class="input-group-text"><i class="bx bx-search"></i></span>
          <input type="text" name="search" class="form-control"
                 placeholder="Nombre o correo…"
                 value="<?php echo e(request('search')); ?>">
        </div>
      </div>

      
      <div class="col-md-4">
        <label class="form-label small fw-semibold">Filtrar por rol</label>
        <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">Todos los roles</option>
          <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $rc = $role->color ?? '#696cff'; ?>
            <option value="<?php echo e($role->name); ?>"
                    <?php echo e(request('role') === $role->name ? 'selected' : ''); ?>>
              <?php echo e($role->name); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>

      
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-sm flex-fill">
          <i class="bx bx-search me-1"></i> Buscar
        </button>
        <?php if(request('search') || request('role')): ?>
          <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-x"></i>
          </a>
        <?php endif; ?>
      </div>

    </form>
  </div>

  
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th style="width:40%">Usuario</th>
          <th>Roles</th>
          <th>Teléfono</th>
          <th>Cumpleaños</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          
          <td>
            <div class="d-flex align-items-center gap-3">
              <a href="<?php echo e(route('users.show', $user)); ?>" class="flex-shrink-0">
                <img src="<?php echo e($user->profile_picture_url); ?>" alt=""
                     class="rounded-circle"
                     width="38" height="38" style="object-fit:cover">
              </a>
              <div>
                <a href="<?php echo e(route('users.show', $user)); ?>"
                   class="fw-semibold text-dark lh-1 text-decoration-none d-block">
                  <?php echo e($user->name); ?>

                </a>
                <small class="text-muted"><?php echo e($user->email); ?></small>
              </div>
            </div>
          </td>

          
          <td>
            <div class="d-flex flex-wrap gap-1">
              <?php $__empty_2 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                <?php $rc = $role->color ?? '#696cff'; ?>
                <span class="badge rounded-pill d-inline-flex align-items-center gap-1 fw-semibold"
                      style="background:<?php echo e($rc); ?>1a;color:<?php echo e($rc); ?>;border:1px solid <?php echo e($rc); ?>40;font-size:.75rem;padding:.3em .65em">
                  <?php if($role->icon): ?><i class="bx <?php echo e($role->icon); ?>" style="font-size:.85rem"></i><?php endif; ?>
                  <?php echo e($role->name); ?>

                </span>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                <span class="text-muted small">Invitado</span>
              <?php endif; ?>
            </div>
          </td>

          <td class="text-muted small"><?php echo e($user->phone ?? '—'); ?></td>

          <td class="text-muted small">
            <?php echo e($user->birthday ? $user->birthday->format('d/m/Y') : '—'); ?>

          </td>

          
          <td class="text-end">
            <div class="d-inline-flex gap-1">
              <a href="<?php echo e(route('users.show', $user)); ?>"
                 class="btn btn-sm btn-outline-secondary" title="Ver perfil">
                <i class="bx bx-user"></i>
              </a>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.edit')): ?>
                <a href="<?php echo e(route('users.edit', $user)); ?>"
                   class="btn btn-sm btn-outline-primary" title="Editar">
                  <i class="bx bx-edit"></i>
                </a>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.delete')): ?>
                <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar al usuario <?php echo e(addslashes($user->name)); ?>?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                    <i class="bx bx-trash"></i>
                  </button>
                </form>
              <?php endif; ?>
              
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('users.edit')): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->denies('users.delete')): ?>
                  <a href="<?php echo e(route('users.edit', $user)); ?>"
                     class="btn btn-sm btn-outline-secondary" title="Ver">
                    <i class="bx bx-show"></i>
                  </a>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
          <td colspan="5" class="text-center py-5 text-muted">
            <i class="bx bx-user-x fs-1 d-block mb-2"></i>
            No se encontraron usuarios.
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  
  <?php if($users->hasPages()): ?>
  <div class="card-footer d-flex justify-content-between align-items-center">
    <small class="text-muted">
      Mostrando <?php echo e($users->firstItem()); ?>–<?php echo e($users->lastItem()); ?> de <?php echo e($users->total()); ?> usuarios
    </small>
    <?php echo e($users->links()); ?>

  </div>
  <?php endif; ?>

</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
     aria-labelledby="offcanvasAddUserLabel" style="width:420px">
  <div class="offcanvas-header border-bottom">
    <h5 id="offcanvasAddUserLabel" class="offcanvas-title">
      <i class="bx bx-user-plus me-2 text-primary"></i>Crear usuario
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">

    <?php if($errors->any()): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?php echo e($errors->first()); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <form action="<?php echo e(route('users.store')); ?>" method="POST" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>

      
      <div class="mb-4 text-center">
        <img id="oc-preview" src="<?php echo e(asset('assets/img/avatars/default.png')); ?>"
             class="rounded-circle" width="80" height="80" style="object-fit:cover">
        <div class="mt-2">
          <label class="btn btn-sm btn-outline-secondary mb-0" style="cursor:pointer">
            <i class="bx bx-camera me-1"></i> Foto
            <input type="file" name="profile_picture" accept="image/*" class="d-none"
                   onchange="ocPreview(this)">
          </label>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Nombre <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control form-control-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               value="<?php echo e(old('name')); ?>" placeholder="Juan Pérez" required>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Nickname</label>
        <div class="input-group input-group-sm">
          <span class="input-group-text text-muted">@</span>
          <input type="text" name="nickname" class="form-control <?php $__errorArgs = ['nickname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                 value="<?php echo e(old('nickname')); ?>" placeholder="mi-nickname">
        </div>
        <?php $__errorArgs = ['nickname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Correo <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control form-control-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               value="<?php echo e(old('email')); ?>" placeholder="correo@dominio.com" required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="row g-2 mb-3">
        <div class="col-6">
          <label class="form-label small fw-semibold">Teléfono</label>
          <input type="text" name="phone" class="form-control form-control-sm"
                 value="<?php echo e(old('phone')); ?>" placeholder="+52 55 1234 5678">
        </div>
        <div class="col-6">
          <label class="form-label small fw-semibold">Cumpleaños</label>
          <input type="date" name="birthday" class="form-control form-control-sm"
                 value="<?php echo e(old('birthday')); ?>">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Contraseña <span class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control form-control-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="mb-4">
        <label class="form-label small fw-semibold">Confirmar contraseña <span class="text-danger">*</span></label>
        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
      </div>

      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.edit')): ?>
      <div class="mb-4">
        <label class="form-label small fw-semibold">Roles</label>
        <div class="d-flex flex-wrap gap-2">
          <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $rc      = $role->color ?? '#696cff';
            $checked = in_array($role->name, old('roles', []));
            $bgStyle = $checked
              ? 'background:' . $rc . '22;border-color:' . $rc . ';'
              : 'background:#fff;border-color:' . $rc . '40;';
          ?>
          <label for="oc_role_<?php echo e($role->id); ?>"
                 class="role-card d-flex align-items-center gap-2 px-3 py-2 rounded border"
                 data-color="<?php echo e($rc); ?>"
                 style="<?php echo e($bgStyle); ?> cursor:pointer;user-select:none;transition:background .15s,border-color .15s">
            <input class="form-check-input m-0 flex-shrink-0" type="checkbox"
                   name="roles[]" value="<?php echo e($role->name); ?>" id="oc_role_<?php echo e($role->id); ?>"
                   <?php echo e($checked ? 'checked' : ''); ?>>
            <?php if($role->icon): ?>
              <i class="bx <?php echo e($role->icon); ?>" style="color:<?php echo e($rc); ?>;font-size:.95rem"></i>
            <?php endif; ?>
            <span class="fw-semibold small" style="color:<?php echo e($rc); ?>"><?php echo e($role->name); ?></span>
          </label>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php if($roles->isEmpty()): ?>
            <small class="text-muted">No hay roles creados todavía.</small>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-sm flex-fill">
          <i class="bx bx-save me-1"></i> Guardar
        </button>
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="offcanvas">
          Cancelar
        </button>
      </div>

    </form>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
// Avatar preview in offcanvas
function ocPreview(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) { document.getElementById('oc-preview').src = e.target.result; };
    reader.readAsDataURL(input.files[0]);
  }
}

// Role card toggle
document.querySelectorAll('.role-card').forEach(function (label) {
  var cb    = label.querySelector('input[type="checkbox"]');
  var color = label.dataset.color || '#696cff';
  if (!cb) return;
  cb.addEventListener('change', function () {
    if (cb.checked) {
      label.style.background  = color + '22';
      label.style.borderColor = color;
    } else {
      label.style.background  = '#fff';
      label.style.borderColor = color + '40';
    }
  });
});

// Re-open offcanvas after validation error (errors present)
<?php if($errors->any()): ?>
  document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('offcanvasAddUser');
    if (el) new bootstrap.Offcanvas(el).show();
  });
<?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/users/index.blade.php ENDPATH**/ ?>