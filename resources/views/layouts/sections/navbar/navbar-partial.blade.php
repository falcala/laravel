@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
@endphp

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if(isset($navbarFull))
<div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
    <a href="{{url('/')}}" class="app-brand-link gap-2">
        <span class="app-brand-logo demo">@include('_partials.macros')</span>
        <span class="app-brand-text demo menu-text fw-bold text-heading">{{config('variables.templateName')}}</span>
    </a>
</div>
@endif

<!-- ! Not required for layout-without-menu -->
@if(!isset($navbarHideToggle))
<div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="icon-base bx bx-menu icon-md"></i>
    </a>
</div>
@endif

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
        @auth
        @php
          $me        = auth()->user();
          $firstRole = $me->roles->first();
          $roleColor = $firstRole?->color ?? '#696cff';
          $roleLabel = $firstRole?->name ?? 'Sin rol';
        @endphp
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ $me->profile_picture_url }}" alt="{{ $me->name }}" class="w-px-40 h-auto rounded-circle" style="object-fit:cover">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                {{-- Identity --}}
                <li>
                    <a class="dropdown-item" href="{{ route('users.show', $me) }}">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-online">
                                    <img src="{{ $me->profile_picture_url }}" alt="{{ $me->name }}" class="w-px-40 h-auto rounded-circle" style="object-fit:cover">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 lh-1">{{ $me->name }}</h6>
                                @if($me->nickname)
                                  <small class="text-primary">{{ '@' . $me->nickname }}</small>
                                @else
                                  <small class="text-muted">
                                    <span class="badge rounded-pill fw-semibold"
                                          style="background:{{ $roleColor }}1a;color:{{ $roleColor }};border:1px solid {{ $roleColor }}40;font-size:.7rem">
                                      @if($firstRole?->icon)<i class="bx {{ $firstRole->icon }} me-1"></i>@endif{{ $roleLabel }}
                                    </span>
                                  </small>
                                @endif
                            </div>
                        </div>
                    </a>
                </li>
                <li><div class="dropdown-divider my-1"></div></li>

                {{-- Mi perfil --}}
                <li>
                    <a class="dropdown-item" href="{{ route('users.show', $me) }}">
                        <i class="icon-base bx bx-user icon-md me-3"></i><span>Mi perfil</span>
                    </a>
                </li>

                {{-- Editar mi cuenta --}}
                <li>
                    <a class="dropdown-item" href="{{ route('users.edit', $me) }}">
                        <i class="icon-base bx bx-edit icon-md me-3"></i><span>Editar cuenta</span>
                    </a>
                </li>

                {{-- Mi Front Page --}}
                @can('frontpages.edit')
                <li>
                    <a class="dropdown-item" href="{{ route('frontpages.edit', $me) }}">
                        <i class="icon-base bx bx-globe icon-md me-3"></i><span>Mi Front Page</span>
                    </a>
                </li>
                @endcan

                <li><div class="dropdown-divider my-1"></div></li>

                {{-- Cerrar sesión --}}
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <a class="dropdown-item text-danger" href="#"
                           onclick="document.getElementById('logout-form').submit()">
                            <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Cerrar sesión</span>
                        </a>
                    </form>
                </li>
            </ul>
        </li>
        @endauth
        <!--/ User -->
    </ul>
</div>