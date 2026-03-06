@extends('layouts/contentNavbarLayout')

@section('title', 'Crear usuario')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Crear usuario</h5></div>
      <div class="card-body">

        @if($errors->any())
          <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        {{-- IMPORTANT: enctype for file upload --}}
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- Profile Picture --}}
          <div class="mb-3 text-center">
            <img id="preview" src="{{ asset('assets/img/avatars/default.png') }}"
                 class="rounded-circle mb-2" width="90" height="90" style="object-fit:cover;">
            <div>
              <label class="form-label d-block">Foto de perfil</label>
              <input type="file" name="profile_picture" id="profile_picture"
                     class="form-control @error('profile_picture') is-invalid @enderror"
                     accept="image/*" onchange="previewImage(this)">
              @error('profile_picture') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" />
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Nickname <small class="text-muted">(único, solo letras, números, - y _)</small></label>
            <div class="input-group">
              <span class="input-group-text text-muted">@</span>
              <input type="text" name="nickname" class="form-control @error('nickname') is-invalid @enderror"
                     value="{{ old('nickname') }}" placeholder="mi-nickname" />
            </div>
            @error('nickname') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" />
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Teléfono</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                     value="{{ old('phone') }}" placeholder="+1 234 567 8900" />
              @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Cumpleaños</label>
              <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror"
                     value="{{ old('birthday') }}" />
              @error('birthday') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" />
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" />
          </div>

          @can('roles.edit')
          <div class="mb-3">
            <label class="form-label fw-semibold">Roles</label>
            <div class="d-flex flex-wrap gap-2">
              @foreach($roles as $role)
              @php
                $rc      = $role->color ?? '#696cff';
                $checked = in_array($role->name, old('roles', []));
                $bgStyle = $checked ? 'background:'.$rc.'22;border-color:'.$rc.';' : 'background:#fff;border-color:'.$rc.'40;';
              @endphp
              <label for="role_{{ $role->id }}"
                     class="role-card d-flex align-items-center gap-2 px-3 py-2 rounded border"
                     data-color="{{ $rc }}"
                     style="{{ $bgStyle }} cursor:pointer;user-select:none;transition:background .15s,border-color .15s">
                <input class="form-check-input m-0 flex-shrink-0" type="checkbox"
                       name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}"
                       {{ $checked ? 'checked' : '' }}>
                @if($role->icon)
                  <i class="bx {{ $role->icon }}" style="color:{{ $rc }};font-size:.95rem"></i>
                @endif
                <span class="fw-semibold small" style="color:{{ $rc }}">{{ $role->name }}</span>
              </label>
              @endforeach
            </div>
          </div>
          @endcan

          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="{{ route('users.index') }}" class="btn btn-secondary ms-1">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>

@section('page-script')
<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) { document.getElementById('preview').src = e.target.result; };
    reader.readAsDataURL(input.files[0]);
  }
}
document.querySelectorAll('.role-card').forEach(function (label) {
  var cb = label.querySelector('input[type="checkbox"]');
  var color = label.dataset.color || '#696cff';
  if (!cb) return;
  cb.addEventListener('change', function () {
    label.style.background  = cb.checked ? color + '22' : '#fff';
    label.style.borderColor = cb.checked ? color : color + '40';
  });
});
</script>
@endsection