@extends('layouts/contentNavbarLayout')

@section('title', 'Usuarios')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Usuarios</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
          <i class="bx bx-plus me-1"></i> Agregar usuario
        </a>
      </div>
      <div class="card-body">

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Usuario</th>
                <th>Teléfono</th>
                <th>Cumpleaños</th>
                <th>Roles</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img src="{{ $user->profile_picture_url }}"
                         alt="avatar" class="rounded-circle"
                         width="38" height="38"
                         style="object-fit:cover;">
                    <div>
                      <strong>{{ $user->name }}</strong><br>
                      <small class="text-muted">{{ $user->email }}</small>
                    </div>
                  </div>
                </td>
                <td>{{ $user->phone ?? '—' }}</td>
                <td>{{ $user->birthday ? $user->birthday->format('M d, Y') : '—' }}</td>
                <td>
                  @forelse($user->roles as $role)
                    <span class="badge bg-label-info">{{ $role->name }}</span>
                  @empty
                    <span class="text-muted">Invitado</span>
                  @endforelse
                </td>
                <td>
                  <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning me-1">
                    <i class="bx bx-edit"></i>
                  </a>
                  <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this user?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="5" class="text-center">No hay usuarios.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>
@endsection