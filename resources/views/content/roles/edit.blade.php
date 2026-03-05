@extends('layouts/contentNavbarLayout')

@section('title', 'Editar Permiso')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-9">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Editar Permiso: <strong>{{ $role->name }}</strong></h5></div>
      <div class="card-body">

        @if($errors->any())
          <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('roles.update', $role) }}" method="POST">
          @csrf @method('PUT')

          <div class="mb-3">
            <label class="form-label">Nombre del Permiso</label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $role->name) }}" />
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-4">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="is_default"
                     id="is_default" value="1"
                     {{ old('is_default', $role->is_default) ? 'checked' : '' }}>
              <label class="form-check-label" for="is_default">
                Asignar como Base a nuevos registros
              </label>
            </div>
            <small class="text-muted">Solo puede estar un permiso base asignado.</small>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Permisos</label>
            <small class="text-muted d-block mb-2">
              Utilice las casillas de verificación para conceder acceso. Active o desactive una fila (módulo) o columna (acción) completa a la vez.
            </small>
            @include('content.roles._permissions_table')
          </div>

          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('roles.index') }}" class="btn btn-secondary ms-1">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection