<?php
use Illuminate\Support\Facades\Route;
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="<?php echo e(url('/')); ?>" class="app-brand-link">
            <span class="app-brand-logo demo"><?php echo $__env->make('_partials.macros', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></span>
            <span class="app-brand-text demo menu-text fw-bold ms-2"><?php echo e(config('variables.templateName')); ?></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="icon-base bx bx-chevron-left icon-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
		
		<li class="menu-header small text-uppercase">
		  <span class="menu-header-text">Administración</span>
		</li>
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('roles.edit')): ?>
		<li class="menu-item <?php echo e(request()->routeIs('roles.*') ? 'active open' : ''); ?>">
		  <a href="<?php echo e(route('roles.index')); ?>" class="menu-link">
			<i class="menu-icon tf-icons bx bx-shield"></i>
			<div>Permisos</div>
		  </a>
		</li>
		<?php endif; ?>
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users.edit')): ?>
		<li class="menu-item <?php echo e(request()->routeIs('users.*') ? 'active open' : ''); ?>">
		  <a href="<?php echo e(route('users.index')); ?>" class="menu-link">
			<i class="menu-icon tf-icons bx bx-group"></i>
			<div>Usiarios</div>
		  </a>
		</li>
		<?php endif; ?>
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('frontpages.edit')): ?>
		<li class="menu-item <?php echo e(request()->routeIs('frontpages.*') ? 'active open' : ''); ?>">
		  <a href="<?php echo e(route('frontpages.edit', auth()->id())); ?>" class="menu-link">
			<i class="menu-icon tf-icons bx bx-globe"></i>
			<div>Mi Front Page</div>
		  </a>
		</li>
		<?php endif; ?>
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('frontpages.manage')): ?>
		<li class="menu-item <?php echo e(request()->routeIs('frontpages.index') ? 'active open' : ''); ?>">
		  <a href="<?php echo e(route('frontpages.index')); ?>" class="menu-link">
			<i class="menu-icon tf-icons bx bx-layout"></i>
			<div>Front Pages</div>
		  </a>
		</li>
		<?php endif; ?>
		<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pages.edit')): ?>
		<li class="menu-item <?php echo e(request()->routeIs('pages.*') ? 'active open' : ''); ?>">
		  <a href="<?php echo e(route('pages.edit')); ?>" class="menu-link">
			<i class="menu-icon tf-icons bx bx-file"></i>
			<div>Pagina de inicio</div>
		  </a>
		</li>
		<li class="menu-item <?php echo e(request()->routeIs('media.*') ? 'active open' : ''); ?>">
		  <a href="<?php echo e(route('media.manager')); ?>" class="menu-link">
			<i class="menu-icon tf-icons bx bx-images"></i>
			<div>Media Manager</div>
		  </a>
		</li>
		<?php endif; ?>
        <?php $__currentLoopData = $menuData[0]->menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        

        
        <?php if(isset($menu->menuHeader)): ?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text"><?php echo e(__($menu->menuHeader)); ?></span>
        </li>
        <?php else: ?>

        
        <?php
        $activeClass = null;
        $currentRouteName = Route::currentRouteName();

        if ($currentRouteName === $menu->slug) {
        $activeClass = 'active';
        }
        elseif (isset($menu->submenu)) {
        if (gettype($menu->slug) === 'array') {
        foreach($menu->slug as $slug){
        if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
        $activeClass = 'active open';
        }
        }
        }
        else{
        if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
        $activeClass = 'active open';
        }
        }
        }
        ?>

        
        <li class="menu-item <?php echo e($activeClass); ?>">
            <a href="<?php echo e(isset($menu->url) ? url($menu->url) : 'javascript:void(0);'); ?>" class="<?php echo e(isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link'); ?>" <?php if(isset($menu->target) and !empty($menu->target)): ?> target="_blank" <?php endif; ?>>
                <?php if(isset($menu->icon)): ?>
                <i class="<?php echo e($menu->icon); ?>"></i>
                <?php endif; ?>
                <div><?php echo e(isset($menu->name) ? __($menu->name) : ''); ?></div>
                <?php if(isset($menu->badge)): ?>
                <div class="badge rounded-pill bg-<?php echo e($menu->badge[0]); ?> text-uppercase ms-auto"><?php echo e($menu->badge[1]); ?></div>
                <?php endif; ?>
            </a>

            
            <?php if(isset($menu->submenu)): ?>
            <?php echo $__env->make('layouts.sections.menu.submenu',['menu' => $menu->submenu], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        </li>
		
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

</aside>
<?php /**PATH C:\xampp\htdocs\sneat\resources\views/layouts/sections/menu/verticalMenu.blade.php ENDPATH**/ ?>