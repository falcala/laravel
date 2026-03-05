@php $items = $section->content['items'] ?? []; @endphp

<div class="mb-3">
  <label class="form-label small">Columns</label>
  <select name="content[columns]" class="form-select form-select-sm">
    @foreach([2,3,4] as $col)
      <option value="{{ $col }}" {{ ($section->content['columns'] ?? 3) == $col ? 'selected' : '' }}>
        {{ $col }} Columns
      </option>
    @endforeach
  </select>
</div>

<div id="feature-items">
  @foreach($items as $i => $item)
  <div class="border rounded p-3 mb-2 feature-item">
    <div class="d-flex justify-content-between mb-2">
      <strong>Feature {{ $i + 1 }}</strong>
      <button type="button" class="btn btn-sm btn-outline-danger remove-feature"><i class="bx bx-trash"></i></button>
    </div>
    <div class="row g-2">
      <div class="col-4">
        <label class="form-label small">Icon (Boxicon)</label>
        <input type="text" name="content[items][{{ $i }}][icon]"
               class="form-control form-control-sm" value="{{ $item['icon'] ?? 'bx-star' }}"
               placeholder="bx-rocket" />
      </div>
      <div class="col-8">
        <label class="form-label small">Title</label>
        <input type="text" name="content[items][{{ $i }}][title]"
               class="form-control form-control-sm" value="{{ $item['title'] ?? '' }}" />
      </div>
      <div class="col-12">
        <label class="form-label small">Description</label>
        <input type="text" name="content[items][{{ $i }}][description]"
               class="form-control form-control-sm" value="{{ $item['description'] ?? '' }}" />
      </div>
    </div>
  </div>
  @endforeach
</div>

<button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1" id="add-feature">
  <i class="bx bx-plus me-1"></i> Add Feature
</button>

<script>
(function() {
  let count = {{ count($items) }};
  document.getElementById('add-feature').addEventListener('click', () => {
    const tpl = `<div class="border rounded p-3 mb-2 feature-item">
      <div class="d-flex justify-content-between mb-2">
        <strong>Feature ${count + 1}</strong>
        <button type="button" class="btn btn-sm btn-outline-danger remove-feature"><i class="bx bx-trash"></i></button>
      </div>
      <div class="row g-2">
        <div class="col-4"><label class="form-label small">Icon</label>
          <input type="text" name="content[items][${count}][icon]" class="form-control form-control-sm" placeholder="bx-star" /></div>
        <div class="col-8"><label class="form-label small">Title</label>
          <input type="text" name="content[items][${count}][title]" class="form-control form-control-sm" /></div>
        <div class="col-12"><label class="form-label small">Description</label>
          <input type="text" name="content[items][${count}][description]" class="form-control form-control-sm" /></div>
      </div></div>`;
    document.getElementById('feature-items').insertAdjacentHTML('beforeend', tpl);
    count++;
    bindRemove();
  });
  function bindRemove() {
    document.querySelectorAll('.remove-feature').forEach(b => b.onclick = () => b.closest('.feature-item').remove());
  }
  bindRemove();
})();
</script>