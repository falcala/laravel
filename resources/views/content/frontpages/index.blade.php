@extends('layouts/contentNavbarLayout')

@section('title', 'Front Pages')

@section('content')
<div class="card">
  <div class="card-header d-flex align-items-center gap-3">
    <div class="flex-grow-1">
      <h5 class="mb-0"><i class="bx bx-layout me-2 text-primary"></i>Front Pages</h5>
      <small class="text-muted">{{ $users->count() }} usuarios</small>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>Usuario</th>
          <th>URL pública</th>
          <th>Estado</th>
          <th>Secciones</th>
          <th class="text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        @php $page = $pages->get($user->id); @endphp
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              <img src="{{ $user->profile_picture_url }}" class="rounded-circle" width="36" height="36" style="object-fit:cover">
              <div>
                <div class="fw-semibold lh-1">{{ $user->name }}</div>
                @if($user->nickname)
                  <small class="text-primary">@{{ $user->nickname }}</small>
                @else
                  <small class="text-muted fst-italic">Sin nickname</small>
                @endif
              </div>
            </div>
          </td>
          <td>
            @if($user->nickname)
              <a href="{{ route('frontpages.show', $user->nickname) }}" target="_blank"
                 class="text-muted small text-decoration-none">
                <i class="bx bx-link-external me-1"></i>/u/{{ $user->nickname }}
              </a>
            @else
              <span class="text-muted small">—</span>
            @endif
          </td>
          <td>
            @if(!$page)
              <span class="badge bg-label-secondary">Sin página</span>
            @elseif($page->is_published)
              <span class="badge bg-label-success">Publicada</span>
            @else
              <span class="badge bg-label-warning">Borrador</span>
            @endif
          </td>
          <td>
            <span class="text-muted small">{{ $page ? $page->sections->count() : 0 }} secciones</span>
          </td>
          <td class="text-end">
            <a href="{{ route('frontpages.edit', $user) }}"
               class="btn btn-sm btn-outline-primary" title="Editar front page">
              <i class="bx bx-edit"></i>
            </a>
            @if($user->nickname && $page && $page->is_published)
              <a href="{{ route('frontpages.show', $user->nickname) }}" target="_blank"
                 class="btn btn-sm btn-outline-secondary ms-1" title="Ver página">
                <i class="bx bx-link-external"></i>
              </a>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-5 text-muted">
            <i class="bx bx-layout fs-1 d-block mb-2"></i>
            No hay usuarios disponibles.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
