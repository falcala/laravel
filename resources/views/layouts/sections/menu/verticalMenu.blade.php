@php
use Illuminate\Support\Facades\Route;
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{url('/')}}" class="app-brand-link">
            <span class="app-brand-logo demo">@include('_partials.macros')</span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="icon-base bx bx-chevron-left icon-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
		{{-- Roles & Users --}}
		<li class="menu-header small text-uppercase">
		  <span class="menu-header-text">Administración</span>
		</li>
		@can('roles.edit')
		<li class="menu-item {{ request()->routeIs('roles.*') ? 'active open' : '' }}">
		  <a href="{{ route('roles.index') }}" class="menu-link">
			<i class="menu-icon tf-icons bx bx-shield"></i>
			<div>Permisos</div>
		  </a>
		</li>
		@endcan
		@can('users.edit')
		<li class="menu-item {{ request()->routeIs('users.*') ? 'active open' : '' }}">
		  <a href="{{ route('users.index') }}" class="menu-link">
			<i class="menu-icon tf-icons bx bx-group"></i>
			<div>Usiarios</div>
		  </a>
		</li>
		@endcan
		@can('frontpages.edit')
		<li class="menu-item {{ request()->routeIs('frontpages.*') ? 'active open' : '' }}">
		  <a href="{{ route('frontpages.edit', auth()->id()) }}" class="menu-link">
			<i class="menu-icon tf-icons bx bx-globe"></i>
			<div>Mi Front Page</div>
		  </a>
		</li>
		@endcan
		@can('frontpages.manage')
		<li class="menu-item {{ request()->routeIs('frontpages.index') ? 'active open' : '' }}">
		  <a href="{{ route('frontpages.index') }}" class="menu-link">
			<i class="menu-icon tf-icons bx bx-layout"></i>
			<div>Front Pages</div>
		  </a>
		</li>
		@endcan
		@can('pages.edit')
		<li class="menu-item {{ request()->routeIs('pages.*') ? 'active open' : '' }}">
		  <a href="{{ route('pages.edit') }}" class="menu-link">
			<i class="menu-icon tf-icons bx bx-file"></i>
			<div>Pagina de inicio</div>
		  </a>
		</li>
		<li class="menu-item {{ request()->routeIs('media.*') ? 'active open' : '' }}">
		  <a href="{{ route('media.manager') }}" class="menu-link">
			<i class="menu-icon tf-icons bx bx-images"></i>
			<div>Media Manager</div>
		  </a>
		</li>
		@endcan
        @foreach ($menuData[0]->menu as $menu)

        {{-- adding active and open class if child is active --}}

        {{-- menu headers --}}
        @if (isset($menu->menuHeader))
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
        </li>
        @else

        {{-- active menu method --}}
        @php
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
        @endphp

        {{-- main menu --}}
        <li class="menu-item {{$activeClass}}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
                @endisset
                <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                @isset($menu->badge)
                <div class="badge rounded-pill bg-{{ $menu->badge[0] }} text-uppercase ms-auto">{{ $menu->badge[1] }}</div>
                @endisset
            </a>

            {{-- submenu --}}
            @isset($menu->submenu)
            @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
            @endisset
        </li>
		
        @endif
        @endforeach
    </ul>

</aside>
