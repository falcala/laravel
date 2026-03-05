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

  // Init on load
  syncRowToggles();
  syncColToggles();
  syncMasterToggle();
});
</script>
@endpush
@endonce