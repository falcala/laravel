@extends('layouts/contentNavbarLayout')

@section('title', 'Permisos')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Roles</h5>
		@can('roles.create')
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
          <i class="bx bx-plus me-1"></i> Agregar Role
        </a>
		@endcan
      </div>
      <div class="card-body">

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
				<th>#</th>
				<th>Permiso</th>
				<th>Base</th>
				<th>Usuarios</th>
				<th>Permisos</th>
				<th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($roles as $role)
              <tr>
				<td>{{ $role->id }}</td>
                <td>
                  @php $roleColor = $role->color ?? '#696cff'; @endphp
                  <span class="badge rounded-pill d-inline-flex align-items-center gap-1 fw-semibold"
                        style="background:{{ $roleColor }}1a;color:{{ $roleColor }};border:1px solid {{ $roleColor }}40;font-size:.8rem;padding:.35em .75em">
                    @if($role->icon)
                      <i class="bx {{ $role->icon }}" style="font-size:.95rem"></i>
                    @endif
                    {{ $role->name }}
                  </span>
                </td>
				<td>
				  @if($role->is_default)
					<span class="badge bg-success">Base</span>
				  @else
					<span class="text-muted">—</span>
				  @endif
				</td>
                <td>{{ $role->users_count }}</td>
				<td>
                  @php
                    $modules = collect($role->permissions->pluck('name'))
                        ->groupBy(fn($p) => explode('.', $p)[0])
                        ->map(fn($perms, $module) => [
                            'module'  => $module,
                            'actions' => $perms->map(fn($p) => explode('.', $p)[1])->values()
                        ]);
                  @endphp
                  @foreach($modules as $m)
                    <div class="d-flex align-items-center gap-1 mb-1">
                      <span class="badge bg-label-dark text-capitalize" style="min-width:60px">{{ $m['module'] }}</span>
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
                  @if($modules->isEmpty())
                    <span class="text-muted">Sin permisos</span>
                  @endif
                </td>
                <td>
                  @can('roles.edit')
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning me-1">
                      <i class="bx bx-edit"></i>
                    </a>
                  @endcan
                  @can('roles.delete')
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this role?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                    </form>
                  @endcan
                </td>
              </tr>
              @empty
              <tr><td colspan="4" class="text-center">No hay permisos.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{ $roles->links() }}
      </div>
    </div>
  </div>
</div>
@endsection