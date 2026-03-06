<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
?>

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
<?php if(isset($navbarFull)): ?>
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
    <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
        <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
        <span class="app-brand-text demo menu-text fw-bold text-heading"><?php echo e(config('variables.templateName')); ?></span>
    </a>
</div>
<?php endif; ?>

<!-- ! Not required for layout-without-menu -->
<?php if(!isset($navbarHideToggle)): ?>
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 <?php echo e(isset($contentNavbar) ?' d-xl-none ' : ''); ?>">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base bx bx-menu icon-md"></i>
    </a>
</div>
<?php endif; ?>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="icon-base bx bx-search icon-md"></i>
            <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Search..." aria-label="Search...">
        </div>
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <?php if(auth()->guard()->check()): ?>
        <?php
          $me        = auth()->user();
          $firstRole = $me->roles->first();
          $roleColor = $firstRole?->color ?? '#696cff';
          $roleLabel = $firstRole?->name ?? 'Sin rol';
        ?>
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="<?php echo e($me->profile_picture_url); ?>" alt="<?php echo e($me->name); ?>" class="w-px-40 h-auto rounded-circle" style="object-fit:cover">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                
                <li>
                    <a class="dropdown-item" href="<?php echo e(route('users.show', $me)); ?>">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-online">
                                    <img src="<?php echo e($me->profile_picture_url); ?>" alt="<?php echo e($me->name); ?>" class="w-px-40 h-auto rounded-circle" style="object-fit:cover">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 lh-1"><?php echo e($me->name); ?></h6>
                                <?php if($me->nickname): ?>
                                  <small class="text-primary"><?php echo e('@' . $me->nickname); ?></small>
                                <?php else: ?>
                                  <small class="text-muted">
                                    <span class="badge rounded-pill fw-semibold"
                                          style="background:<?php echo e($roleColor); ?>1a;color:<?php echo e($roleColor); ?>;border:1px solid <?php echo e($roleColor); ?>40;font-size:.7rem">
                                      <?php if($firstRole?->icon): ?><i class="bx <?php echo e($firstRole->icon); ?> me-1"></i><?php endif; ?><?php echo e($roleLabel); ?>

                                    </span>
                                  </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </li>
                <li><div class="dropdown-divider my-1"></div></li>

                
                <li>
                    <a class="dropdown-item" href="<?php echo e(route('users.show', $me)); ?>">
                        <i class="icon-base bx bx-user icon-md me-3"></i><span>Mi perfil</span>
                    </a>
                </li>

                
                <li>
                    <a class="dropdown-item" href="<?php echo e(route('users.edit', $me)); ?>">
                        <i class="icon-base bx bx-edit icon-md me-3"></i><span>Editar cuenta</span>
                    </a>
                </li>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('frontpages.edit')): ?>
                <li>
                    <a class="dropdown-item" href="<?php echo e(route('frontpages.edit', $me)); ?>">
                        <i class="icon-base bx bx-globe icon-md me-3"></i><span>Mi Front Page</span>
                    </a>
                </li>
                <?php endif; ?>

                <li><div class="dropdown-divider my-1"></div></li>

                
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-form">
                        <?php echo csrf_field(); ?>
                        <a class="dropdown-item text-danger" href="#"
                           onclick="document.getElementById('logout-form').submit()">
                            <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Cerrar sesión</span>
                        </a>
                    </form>
                </li>
            </ul>
        </li>
        <?php endif; ?>
        <!--/ User -->
    </ul>
</div><?php /**PATH C:\xampp\htdocs\sneat\resources\views/layouts/sections/navbar/navbar-partial.blade.php ENDPATH**/ ?>