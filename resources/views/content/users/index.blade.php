@extends('layouts/contentNavbarLayout')

@section('title', 'Usuarios')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">

  {{-- ── Header ─────────────────────────────────────────────────── --}}
  <div class="card-header d-flex flex-wrap align-items-center gap-3">
    <div class="flex-grow-1">
      <h5 class="mb-0"><i class="bx bx-group me-2 text-primary"></i>Usuarios</h5>
      <small class="text-muted">{{ $users->total() }} usuarios registrados</small>
    </div>
    <button type="button" class="btn btn-primary btn-sm"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
      <i class="bx bx-plus me-1"></i> Agregar usuario
    </button>
  </div>

  {{-- ── Filters ─────────────────────────────────────────────────── --}}
  <div class="card-body border-bottom pb-3">
    <form method="GET" action="{{ route('users.index') }}" id="filter-form" class="row g-3 align-items-end">

      {{-- Search --}}
      <div class="col-md-5">
        <label class="form-label small fw-semibold">Buscar</label>
        <div class="input-group input-group-sm">
          <span class="input-group-text"><i class="bx bx-search"></i></span>
          <input type="text" name="search" class="form-control"
                 placeholder="Nombre o correo…"
                 value="{{ request('search') }}">
        </div>
      </div>

      {{-- Role filter --}}
      <div class="col-md-4">
        <label class="form-label small fw-semibold">Filtrar por rol</label>
        <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">Todos los roles</option>
          @foreach($roles as $role)
            @php $rc = $role->color ?? '#696cff'; @endphp
            <option value="{{ $role->name }}"
                    {{ request('role') === $role->name ? 'selected' : '' }}>
              {{ $role->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Actions --}}
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary btn-sm flex-fill">
          <i class="bx bx-search me-1"></i> Buscar
        </button>
        @if(request('search') || request('role'))
          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-x"></i>
          </a>
        @endif
      </div>

    </form>
  </div>

  {{-- ── Table ───────────────────────────────────────────────────── --}}
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
        @forelse($users as $user)
        <tr>
          {{-- Avatar + name + email --}}
          <td>
            <div class="d-flex align-items-center gap-3">
              <a href="{{ route('users.show', $user) }}" class="flex-shrink-0">
                <img src="{{ $user->profile_picture_url }}" alt=""
                     class="rounded-circle"
                     width="38" height="38" style="object-fit:cover">
              </a>
              <div>
                <a href="{{ route('users.show', $user) }}"
                   class="fw-semibold text-dark lh-1 text-decoration-none d-block">
                  {{ $user->name }}
                </a>
                <small class="text-muted">{{ $user->email }}</small>
              </div>
            </div>
          </td>

          {{-- Roles --}}
          <td>
            <div class="d-flex flex-wrap gap-1">
              @forelse($user->roles as $role)
                @php $rc = $role->color ?? '#696cff'; @endphp
                <span class="badge rounded-pill d-inline-flex align-items-center gap-1 fw-semibold"
                      style="background:{{ $rc }}1a;color:{{ $rc }};border:1px solid {{ $rc }}40;font-size:.75rem;padding:.3em .65em">
                  @if($role->icon)<i class="bx {{ $role->icon }}" style="font-size:.85rem"></i>@endif
                  {{ $role->name }}
                </span>
              @empty
                <span class="text-muted small">Invitado</span>
              @endforelse
            </div>
          </td>

          <td class="text-muted small">{{ $user->phone ?? '—' }}</td>

          <td class="text-muted small">
            {{ $user->birthday ? $user->birthday->format('d/m/Y') : '—' }}
          </td>

          {{-- Actions --}}
          <td class="text-end">
            <div class="d-inline-flex gap-1">
              <a href="{{ route('users.show', $user) }}"
                 class="btn btn-sm btn-outline-secondary" title="Ver perfil">
                <i class="bx bx-user"></i>
              </a>
              @can('users.edit')
                <a href="{{ route('users.edit', $user) }}"
                   class="btn btn-sm btn-outline-primary" title="Editar">
                  <i class="bx bx-edit"></i>
                </a>
              @endcan
              @can('users.delete')
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Eliminar al usuario {{ addslashes($user->name) }}?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                    <i class="bx bx-trash"></i>
                  </button>
                </form>
              @endcan
              {{-- Show edit to anyone who can see this page if no specific perm --}}
              @cannot('users.edit')
                @cannot('users.delete')
                  <a href="{{ route('users.edit', $user) }}"
                     class="btn btn-sm btn-outline-secondary" title="Ver">
                    <i class="bx bx-show"></i>
                  </a>
                @endcannot
              @endcannot
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-5 text-muted">
            <i class="bx bx-user-x fs-1 d-block mb-2"></i>
            No se encontraron usuarios.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- ── Paginator ───────────────────────────────────────────────── --}}
  @if($users->hasPages())
  <div class="card-footer d-flex justify-content-between align-items-center">
    <small class="text-muted">
      Mostrando {{ $users->firstItem() }}–{{ $users->lastItem() }} de {{ $users->total() }} usuarios
    </small>
    {{ $users->links() }}
  </div>
  @endif

</div>

{{-- ── Offcanvas: Create user ─────────────────────────────────────── --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
     aria-labelledby="offcanvasAddUserLabel" style="width:420px">
  <div class="offcanvas-header border-bottom">
    <h5 id="offcanvasAddUserLabel" class="offcanvas-title">
      <i class="bx bx-user-plus me-2 text-primary"></i>Crear usuario
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- Avatar preview --}}
      <div class="mb-4 text-center">
        <img id="oc-preview" src="{{ asset('assets/img/avatars/default.png') }}"
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
        <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
               value="{{ old('name') }}" placeholder="Juan Pérez" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Nickname</label>
        <div class="input-group input-group-sm">
          <span class="input-group-text text-muted">@</span>
          <input type="text" name="nickname" class="form-control @error('nickname') is-invalid @enderror"
                 value="{{ old('nickname') }}" placeholder="mi-nickname">
        </div>
        @error('nickname')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Correo <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="correo@dominio.com" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="row g-2 mb-3">
        <div class="col-6">
          <label class="form-label small fw-semibold">Teléfono</label>
          <input type="text" name="phone" class="form-control form-control-sm"
                 value="{{ old('phone') }}" placeholder="+52 55 1234 5678">
        </div>
        <div class="col-6">
          <label class="form-label small fw-semibold">Cumpleaños</label>
          <input type="date" name="birthday" class="form-control form-control-sm"
                 value="{{ old('birthday') }}">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label small fw-semibold">Contraseña <span class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="mb-4">
        <label class="form-label small fw-semibold">Confirmar contraseña <span class="text-danger">*</span></label>
        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
      </div>

      @can('roles.edit')
      <div class="mb-4">
        <label class="form-label small fw-semibold">Roles</label>
        <div class="d-flex flex-wrap gap-2">
          @foreach($roles as $role)
          @php
            $rc      = $role->color ?? '#696cff';
            $checked = in_array($role->name, old('roles', []));
            $bgStyle = $checked
              ? 'background:' . $rc . '22;border-color:' . $rc . ';'
              : 'background:#fff;border-color:' . $rc . '40;';
          @endphp
          <label for="oc_role_{{ $role->id }}"
                 class="role-card d-flex align-items-center gap-2 px-3 py-2 rounded border"
                 data-color="{{ $rc }}"
                 style="{{ $bgStyle }} cursor:pointer;user-select:none;transition:background .15s,border-color .15s">
            <input class="form-check-input m-0 flex-shrink-0" type="checkbox"
                   name="roles[]" value="{{ $role->name }}" id="oc_role_{{ $role->id }}"
                   {{ $checked ? 'checked' : '' }}>
            @if($role->icon)
              <i class="bx {{ $role->icon }}" style="color:{{ $rc }};font-size:.95rem"></i>
            @endif
            <span class="fw-semibold small" style="color:{{ $rc }}">{{ $role->name }}</span>
          </label>
          @endforeach
          @if($roles->isEmpty())
            <small class="text-muted">No hay roles creados todavía.</small>
          @endif
        </div>
      </div>
      @endcan

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

@endsection

@section('page-script')
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
@if($errors->any())
  document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('offcanvasAddUser');
    if (el) new bootstrap.Offcanvas(el).show();
  });
@endif
</script>
@endsection
