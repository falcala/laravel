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

          <div class="mb-3">
            <label class="form-label">Asignar permisos</label>
            <div class="row">
              @foreach($roles as $role)
              <div class="col-md-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="roles[]"
                         value="{{ $role->name }}" id="role_{{ $role->id }}"
                         {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                  <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="{{ route('users.index') }}" class="btn btn-secondary ms-1">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>

@push('page-script')
<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('preview').src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endpush
@endsection