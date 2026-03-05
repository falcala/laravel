@php $items = $section->content['items'] ?? []; @endphp

<div class="mb-3">
  <label class="form-label small fw-semibold">Columns</label>
  <select name="content[columns]" class="form-select form-select-sm" style="width:120px">
    @foreach([1,2,3] as $c)
      <option value="{{ $c }}" {{ ($section->content['columns'] ?? 3) == $c ? 'selected' : '' }}>
        {{ $c }} {{ $c === 1 ? 'column' : 'columns' }}
      </option>
    @endforeach
  </select>
</div>

<div id="testimonial-items-{{ $section->id }}">
@foreach($items as $i => $item)
<div class="border rounded p-3 mb-3 testimonial-item">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <strong class="small">Testimonial {{ $i + 1 }}</strong>
    <button type="button" class="btn btn-sm btn-outline-danger remove-testimonial">
      <i class="bx bx-trash"></i> Remove
    </button>
  </div>
  <div class="row g-2">
    <div class="col-md-6">
      <label class="form-label small">Name</label>
      <input type="text" name="content[items][{{ $i }}][name]"
             class="form-control form-control-sm" value="{{ $item['name'] ?? '' }}">
    </div>
    <div class="col-md-6">
      <label class="form-label small">Role / Company</label>
      <input type="text" name="content[items][{{ $i }}][role]"
             class="form-control form-control-sm" value="{{ $item['role'] ?? '' }}">
    </div>
    <div class="col-12">
      <label class="form-label small">Avatar URL</label>
      <input type="text" name="content[items][{{ $i }}][avatar]"
             class="form-control form-control-sm" value="{{ $item['avatar'] ?? '' }}"
             placeholder="https://... (leave blank for initials)">
    </div>
    <div class="col-12">
      <label class="form-label small">Testimonial Text</label>
      <textarea name="content[items][{{ $i }}][text]"
                class="form-control form-control-sm" rows="2">{{ $item['text'] ?? '' }}</textarea>
    </div>
    <div class="col-md-4">
      <label class="form-label small">Rating (1–5)</label>
      <select name="content[items][{{ $i }}][rating]" class="form-select form-select-sm">
        @for($r = 5; $r >= 1; $r--)
          <option value="{{ $r }}" {{ ($item['rating'] ?? 5) == $r ? 'selected' : '' }}>
            {{ $r }} star{{ $r > 1 ? 's' : '' }}
          </option>
        @endfor
      </select>
    </div>
  </div>
</div>
@endforeach
</div>

<button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1 add-testimonial"
        data-section="{{ $section->id }}">
  <i class="bx bx-plus me-1"></i> Add Testimonial
</button>

<script>
(function () {
  var secId = '{{ $section->id }}';
  var count = {{ count($items) }};

  function bindRemove() {
    document.querySelectorAll('#testimonial-items-' + secId + ' .remove-testimonial').forEach(function (btn) {
      btn.onclick = function () { btn.closest('.testimonial-item').remove(); };
    });
  }
  bindRemove();

  document.querySelector('.add-testimonial[data-section="' + secId + '"]')
    .addEventListener('click', function () {
      var idx = count++;
      var tpl = `
        <div class="border rounded p-3 mb-3 testimonial-item">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="small">Testimonial ${idx + 1}</strong>
            <button type="button" class="btn btn-sm btn-outline-danger remove-testimonial">
              <i class="bx bx-trash"></i> Remove
            </button>
          </div>
          <div class="row g-2">
            <div class="col-md-6">
              <label class="form-label small">Name</label>
              <input type="text" name="content[items][${idx}][name]" class="form-control form-control-sm">
            </div>
            <div class="col-md-6">
              <label class="form-label small">Role / Company</label>
              <input type="text" name="content[items][${idx}][role]" class="form-control form-control-sm">
            </div>
            <div class="col-12">
              <label class="form-label small">Avatar URL</label>
              <input type="text" name="content[items][${idx}][avatar]"
                     class="form-control form-control-sm" placeholder="https://... (leave blank for initials)">
            </div>
            <div class="col-12">
              <label class="form-label small">Testimonial Text</label>
              <textarea name="content[items][${idx}][text]" class="form-control form-control-sm" rows="2"></textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Rating (1–5)</label>
              <select name="content[items][${idx}][rating]" class="form-select form-select-sm">
                <option value="5" selected>5 stars</option>
                <option value="4">4 stars</option>
                <option value="3">3 stars</option>
                <option value="2">2 stars</option>
                <option value="1">1 star</option>
              </select>
            </div>
          </div>
        </div>`;
      document.getElementById('testimonial-items-' + secId).insertAdjacentHTML('beforeend', tpl);
      bindRemove();
    });
}());
</script>