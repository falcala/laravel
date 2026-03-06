@php
  $currentIcon  = old('icon',  $role->icon  ?? 'bx-shield');
  $currentColor = old('color', $role->color ?? '#696cff');
@endphp

<div class="mb-4">
  <label class="form-label fw-semibold">Apariencia del Role</label>

  <div class="d-flex align-items-center gap-3 flex-wrap">

    {{-- Live icon preview --}}
    <div id="role-icon-preview"
         class="rounded d-flex align-items-center justify-content-center flex-shrink-0"
         style="width:52px;height:52px;background:{{ $currentColor }}22;font-size:1.8rem;transition:all .2s">
      <i class="bx {{ $currentIcon }}" style="color:{{ $currentColor }}"></i>
    </div>

    {{-- Hidden icon field --}}
    <input type="hidden" name="icon" id="role-icon-input" value="{{ $currentIcon }}">

    {{-- Elegir icono --}}
    <button type="button" class="btn btn-outline-secondary btn-sm" id="role-icon-pick-btn">
      <i class="bx bx-search me-1"></i> Elegir icono
    </button>

    {{-- Color picker --}}
    <div class="d-flex align-items-center gap-2">
      <label class="form-label small mb-0 text-muted">Color</label>
      <input type="color" name="color" id="role-color-picker"
             class="form-control form-control-color"
             value="{{ $currentColor }}"
             style="width:40px;height:34px;padding:2px">
      <input type="text" id="role-color-hex"
             class="form-control form-control-sm"
             value="{{ $currentColor }}"
             style="width:90px"
             placeholder="#696cff">
    </div>

  </div>
</div>

{{-- ── Icon Picker Modal ────────────────────────────────────────────── --}}
<div class="modal fade" id="roleIconPickerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title mb-0"><i class="bx bx-search me-2"></i>Elegir icono Boxicon</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <div class="input-group input-group-sm">
            <span class="input-group-text"><i class="bx bx-search"></i></span>
            <input type="text" id="role-icon-search" class="form-control"
                   placeholder="Buscar icono… (ej: user, star, home)">
          </div>
        </div>
        <div id="role-icon-grid" class="row g-2" style="max-height:380px;overflow-y:auto"></div>
      </div>
    </div>
  </div>
</div>
