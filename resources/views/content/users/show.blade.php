@extends('layouts/contentNavbarLayout')

@section('title', 'Perfil — ' . $user->name)

@section('content')
<div class="row g-4">

  {{-- ── Left column: identity card ──────────────────────────────── --}}
  <div class="col-md-4 col-lg-3">

    <div class="card text-center">
      <div class="card-body pt-5 pb-4">

        {{-- Avatar --}}
        <div class="mb-3">
          <img src="{{ $user->profile_picture_url }}"
               alt="{{ $user->name }}"
               class="rounded-circle shadow-sm"
               width="110" height="110"
               style="object-fit:cover;border:3px solid #e7e7ff">
        </div>

        {{-- Name + email --}}
        <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>
        @if($user->nickname)
          <p class="text-primary small mb-0 fw-semibold lh-1">{{ '@' . $user->nickname }}</p>
        @endif
        <p class="text-muted small mb-3 mt-1">{{ $user->email }}</p>

        {{-- Roles --}}
        <div class="d-flex flex-wrap justify-content-center gap-1 mb-4">
          @forelse($user->roles as $role)
            @php $rc = $role->color ?? '#696cff'; @endphp
            <span class="badge rounded-pill d-inline-flex align-items-center gap-1 fw-semibold"
                  style="background:{{ $rc }}1a;color:{{ $rc }};border:1px solid {{ $rc }}40;
                         font-size:.8rem;padding:.35em .8em">
              @if($role->icon)<i class="bx {{ $role->icon }}" style="font-size:.9rem"></i>@endif
              {{ $role->name }}
            </span>
          @empty
            <span class="badge bg-label-secondary">Invitado</span>
          @endforelse
        </div>

        {{-- Action buttons --}}
        <div class="d-flex justify-content-center gap-2 flex-wrap">
          @can('users.edit')
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">
              <i class="bx bx-edit me-1"></i> Editar
            </a>
          @endcan
          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i> Volver
          </a>
        </div>

      </div>

      <div class="card-footer bg-transparent border-top text-muted small py-3">
        <i class="bx bx-calendar me-1"></i>
        Miembro desde {{ $user->created_at->format('M Y') }}
      </div>
    </div>

    {{-- Delete card (only for those with permission, not self) --}}
    @can('users.delete')
      @if($user->id !== auth()->id())
      <div class="card border-danger mt-3">
        <div class="card-body py-3 text-center">
          <p class="small text-muted mb-2">Zona de peligro</p>
          <form action="{{ route('users.destroy', $user) }}" method="POST"
                onsubmit="return confirm('¿Eliminar al usuario {{ addslashes($user->name) }}? Esta acción no se puede deshacer.')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger w-100">
              <i class="bx bx-trash me-1"></i> Eliminar usuario
            </button>
          </form>
        </div>
      </div>
      @endif
    @endcan

  </div>

  {{-- ── Right column: details ────────────────────────────────────── --}}
  <div class="col-md-8 col-lg-9">

    {{-- Contact info --}}
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0"><i class="bx bx-user me-2 text-primary"></i>Información de contacto</h6>
      </div>
      <div class="card-body">
        <div class="row g-3">

          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-3">
              <div class="flex-shrink-0 rounded d-flex align-items-center justify-content-center"
                   style="width:40px;height:40px;background:rgba(105,108,255,.1)">
                <i class="bx bx-envelope text-primary"></i>
              </div>
              <div>
                <div class="text-muted small">Correo electrónico</div>
                <div class="fw-semibold">
                  <a href="mailto:{{ $user->email }}" class="text-body">{{ $user->email }}</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-3">
              <div class="flex-shrink-0 rounded d-flex align-items-center justify-content-center"
                   style="width:40px;height:40px;background:rgba(105,108,255,.1)">
                <i class="bx bx-phone text-primary"></i>
              </div>
              <div>
                <div class="text-muted small">Teléfono</div>
                <div class="fw-semibold">
                  {{ $user->phone ?: '—' }}
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-3">
              <div class="flex-shrink-0 rounded d-flex align-items-center justify-content-center"
                   style="width:40px;height:40px;background:rgba(105,108,255,.1)">
                <i class="bx bx-cake text-primary"></i>
              </div>
              <div>
                <div class="text-muted small">Cumpleaños</div>
                <div class="fw-semibold">
                  @if($user->birthday)
                    {{ $user->birthday->format('d \d\e F \d\e Y') }}
                    <span class="text-muted small ms-1">
                      ({{ $user->birthday->age }} años)
                    </span>
                  @else
                    —
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-3">
              <div class="flex-shrink-0 rounded d-flex align-items-center justify-content-center"
                   style="width:40px;height:40px;background:rgba(105,108,255,.1)">
                <i class="bx bx-shield text-primary"></i>
              </div>
              <div>
                <div class="text-muted small">Estado de cuenta</div>
                <div>
                  <span class="badge bg-label-success">Activo</span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- Roles & permissions detail --}}
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0"><i class="bx bx-key me-2 text-primary"></i>Roles y permisos</h6>
      </div>
      <div class="card-body">
        @forelse($user->roles as $role)
          @php $rc = $role->color ?? '#696cff'; @endphp
          <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">

            {{-- Role header --}}
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="badge rounded-pill d-inline-flex align-items-center gap-1 fw-semibold"
                    style="background:{{ $rc }}1a;color:{{ $rc }};border:1px solid {{ $rc }}40;
                           font-size:.85rem;padding:.4em .9em">
                @if($role->icon)<i class="bx {{ $role->icon }}" style="font-size:.95rem"></i>@endif
                {{ $role->name }}
              </span>
              @if($role->is_default)
                <span class="badge bg-label-success text-xs">Base</span>
              @endif
            </div>

            {{-- Permissions grouped by module --}}
            @php
              $modules = $role->permissions
                ->groupBy(fn($p) => explode('.', $p->name)[0])
                ->map(fn($perms, $mod) => [
                  'module'  => $mod,
                  'actions' => $perms->map(fn($p) => explode('.', $p->name)[1])->values(),
                ]);
            @endphp

            @if($modules->isNotEmpty())
              <div class="d-flex flex-wrap gap-2 ms-1">
                @foreach($modules as $m)
                  <div class="d-flex align-items-center gap-1">
                    <span class="badge bg-label-dark text-capitalize" style="min-width:60px">
                      {{ $m['module'] }}
                    </span>
                    @foreach($m['actions'] as $action)
                      <span class="badge bg-label-{{ match($action) {
                        'view'   => 'info',
                        'create' => 'success',
                        'edit'   => 'warning',
                        'delete' => 'danger',
                        default  => 'secondary'
                      } }}">{{ $action }}</span>
                    @endforeach
                  </div>
                @endforeach
              </div>
            @else
              <span class="text-muted small ms-1">Sin permisos específicos.</span>
            @endif

          </div>
        @empty
          <div class="text-center text-muted py-4">
            <i class="bx bx-shield-x fs-1 d-block mb-2"></i>
            <p class="mb-0">Este usuario no tiene roles asignados.</p>
          </div>
        @endforelse
      </div>
    </div>

  </div>
</div>
@endsection
