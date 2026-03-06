<div class="table-responsive mb-3">
  <table class="table table-bordered text-center align-middle">
    <thead class="table-light">
      <tr>
        <th class="text-start" style="width:160px">Modulo</th>
        @foreach($actions as $action)
          <th class="text-capitalize">
            <span class="badge bg-label-{{ match($action) {
              'view'   => 'info',
              'create' => 'success',
              'edit'   => 'warning',
              'delete' => 'danger',
              default  => 'secondary'
            } }}">{{ $action }}</span>
          </th>
        @endforeach
        <th>Todo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($modules as $module)
      <tr>
        <td class="text-start fw-semibold text-capitalize">{{ $module }}</td>
        @foreach($actions as $action)
          @php $perm = "{$module}.{$action}"; @endphp
          <td>
            <div class="form-check d-flex justify-content-center">
              <input class="form-check-input perm-check perm-{{ $module }}"
                     type="checkbox"
                     name="permissions[]"
                     value="{{ $perm }}"
                     id="perm_{{ $module }}_{{ $action }}"
                     {{ in_array($perm, $rolePermissions ?? old('permissions', [])) ? 'checked' : '' }}>
            </div>
          </td>
        @endforeach
        <td>
          {{-- Select all for this row --}}
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input row-toggle"
                   type="checkbox"
                   data-module="{{ $module }}"
                   title="Toggle all for {{ $module }}"
                   {{ collect($actions)->every(fn($a) => in_array("{$module}.{$a}", $rolePermissions ?? old('permissions', []))) ? 'checked' : '' }}>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td class="text-start fw-semibold">All Modules</td>
        @foreach($actions as $action)
          <td>
            <div class="form-check d-flex justify-content-center">
              <input class="form-check-input col-toggle"
                     type="checkbox"
                     data-action="{{ $action }}"
                     title="Toggle all {{ $action }}"
                     {{ collect($modules)->every(fn($m) => in_array("{$m}.{$action}", $rolePermissions ?? old('permissions', []))) ? 'checked' : '' }}>
            </div>
          </td>
        @endforeach
        <td>
          <div class="form-check d-flex justify-content-center">
            <input class="form-check-input" type="checkbox" id="toggle-all" title="Toggle everything">
          </div>
        </td>
      </tr>
    </tfoot>
  </table>
</div>

@if(!empty($extra))
<div class="mb-3">
  <p class="small fw-semibold text-muted mb-2 mt-3">Permisos especiales</p>
  <div class="d-flex flex-wrap gap-3">
    @foreach($extra as $perm => $label)
    @php
      $epChecked = in_array($perm, $rolePermissions ?? old('permissions', []));
      [$eMod, $eAct] = explode('.', $perm, 2);
    @endphp
    <label class="extra-perm-card d-flex align-items-start gap-2 px-3 py-2 rounded border"
           data-perm="{{ $perm }}"
           style="{{ $epChecked ? 'background:#696cff14;border-color:#696cff;' : 'background:#fff;border-color:#d9dee3;' }} cursor:pointer;user-select:none;transition:background .15s,border-color .15s;max-width:340px">
      <input class="form-check-input mt-1 flex-shrink-0 perm-check"
             type="checkbox"
             name="permissions[]"
             value="{{ $perm }}"
             id="perm_extra_{{ str_replace('.', '_', $perm) }}"
             {{ $epChecked ? 'checked' : '' }}>
      <div>
        <div class="fw-semibold small mb-1">
          <span class="badge bg-label-secondary text-uppercase me-1" style="font-size:.65rem">{{ $eMod }}</span>
          <span class="badge bg-label-primary" style="font-size:.65rem">{{ $eAct }}</span>
        </div>
        <div class="text-muted" style="font-size:.8rem">{{ $label }}</div>
      </div>
    </label>
    @endforeach
  </div>
</div>
@endif

@once
@push('page-script')
<script>
document.addEventListener('DOMContentLoaded', () => {

  // Row toggle (all actions for one module)
  document.querySelectorAll('.row-toggle').forEach(toggle => {
    toggle.addEventListener('change', () => {
      document.querySelectorAll(`.perm-${toggle.dataset.module}`)
        .forEach(cb => cb.checked = toggle.checked);
      syncColToggles();
      syncMasterToggle();
    });
  });

  // Column toggle (one action across all modules)
  document.querySelectorAll('.col-toggle').forEach(toggle => {
    toggle.addEventListener('change', () => {
      document.querySelectorAll(`input[name="permissions[]"]`)
        .forEach(cb => {
          if (cb.value.endsWith('.' + toggle.dataset.action)) {
            cb.checked = toggle.checked;
          }
        });
      syncRowToggles();
      syncMasterToggle();
    });
  });

  // Master toggle (everything)
  document.getElementById('toggle-all').addEventListener('change', function () {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = this.checked);
    document.querySelectorAll('.row-toggle').forEach(cb => cb.checked = this.checked);
    document.querySelectorAll('.col-toggle').forEach(cb => cb.checked = this.checked);
  });

  // Individual checkbox change
  document.querySelectorAll('.perm-check').forEach(cb => {
    cb.addEventListener('change', () => {
      syncRowToggles();
      syncColToggles();
      syncMasterToggle();
    });
  });

  function syncRowToggles() {
    document.querySelectorAll('.row-toggle').forEach(toggle => {
      const boxes = document.querySelectorAll(`.perm-${toggle.dataset.module}`);
      toggle.checked = [...boxes].every(b => b.checked);
    });
  }

  function syncColToggles() {
    document.querySelectorAll('.col-toggle').forEach(toggle => {
      const boxes = [...document.querySelectorAll('input[name="permissions[]"]')]
        .filter(cb => cb.value.endsWith('.' + toggle.dataset.action));
      toggle.checked = boxes.every(b => b.checked);
    });
  }

  function syncMasterToggle() {
    const all  = document.querySelectorAll('.perm-check');
    document.getElementById('toggle-all').checked = [...all].every(b => b.checked);
  }

  // Extra permission card toggle style
  document.querySelectorAll('.extra-perm-card').forEach(function (card) {
    var cb = card.querySelector('input[type="checkbox"]');
    if (!cb) return;
    function applyStyle() {
      if (cb.checked) {
        card.style.background   = '#696cff14';
        card.style.borderColor  = '#696cff';
      } else {
        card.style.background   = '#fff';
        card.style.borderColor  = '#d9dee3';
      }
    }
    cb.addEventListener('change', function () {
      applyStyle();
      syncMasterToggle();
    });
  });

  // Init on load
  syncRowToggles();
  syncColToggles();
  syncMasterToggle();
});
</script>
@endpush
@endonce