@php $items = $section->content['items'] ?? []; @endphp

{{-- Columns --}}
<div class="mb-3">
  <label class="form-label small fw-semibold">Columns</label>
  <select name="content[columns]" class="form-select form-select-sm" style="width:120px">
    @foreach([2,3,4] as $c)
      <option value="{{ $c }}" {{ ($section->content['columns'] ?? 3) == $c ? 'selected' : '' }}>
        {{ $c }} columns
      </option>
    @endforeach
  </select>
</div>

<div id="gallery-items-{{ $section->id }}">
@foreach($items as $i => $item)
<div class="border rounded p-3 mb-3 gallery-item">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <strong class="small">Item {{ $i + 1 }}</strong>
    <button type="button" class="btn btn-sm btn-outline-danger remove-gallery-item">
      <i class="bx bx-trash"></i> Remove
    </button>
  </div>

  {{-- Image URL + Upload --}}
  @if(!empty($item['image']))
    <img src="{{ $item['image'] }}" class="img-fluid rounded mb-2" style="max-height:120px;object-fit:cover;width:100%">
  @endif
  <div class="input-group input-group-sm mb-2">
    <span class="input-group-text"><i class="bx bx-link"></i></span>
    <input type="text" name="content[items][{{ $i }}][image]"
           id="gal_url_{{ $section->id }}_{{ $i }}"
           class="form-control" value="{{ $item['image'] ?? '' }}"
           placeholder="https://... or upload">
  </div>
  <label class="btn btn-outline-secondary btn-sm mb-2">
    <i class="bx bx-upload me-1"></i> Upload
    <input type="file" accept="image/jpeg,image/png,image/webp,image/gif"
           class="d-none gallery-upload"
           data-section="{{ $section->id }}" data-index="{{ $i }}"
           data-url-field="gal_url_{{ $section->id }}_{{ $i }}">
  </label>

  <input type="text" name="content[items][{{ $i }}][caption]"
         class="form-control form-control-sm"
         value="{{ $item['caption'] ?? '' }}" placeholder="Caption (optional)">
</div>
@endforeach
</div>

<button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1 add-gallery-item"
        data-section="{{ $section->id }}">
  <i class="bx bx-plus me-1"></i> Add Item
</button>

<script>
(function () {
  var secId     = '{{ $section->id }}';
  var count     = {{ count($items) }};
  var uploadUrl = '{{ route('pages.sections.upload-slide-image') }}';
  var csrf      = '{{ csrf_token() }}';

  function bindRemove() {
    document.querySelectorAll('#gallery-items-' + secId + ' .remove-gallery-item').forEach(function (btn) {
      btn.onclick = function () { btn.closest('.gallery-item').remove(); };
    });
  }
  bindRemove();

  function bindUploads() {
    document.querySelectorAll('#gallery-items-' + secId + ' .gallery-upload').forEach(function (inp) {
      if (inp.dataset.bound) return;
      inp.dataset.bound = '1';
      inp.addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;
        var fd = new FormData();
        fd.append('image', this.files[0]);
        fd.append('_token', csrf);
        fetch(uploadUrl, { method: 'POST', body: fd })
          .then(function (r) { return r.json(); })
          .then(function (d) {
            if (d.success) {
              var f = document.getElementById(inp.dataset.urlField);
              if (f) f.value = d.url;
            }
          });
      });
    });
  }
  bindUploads();

  document.querySelector('.add-gallery-item[data-section="' + secId + '"]')
    .addEventListener('click', function () {
      var idx = count++;
      var tpl = `
        <div class="border rounded p-3 mb-3 gallery-item">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong class="small">Item ${idx + 1}</strong>
            <button type="button" class="btn btn-sm btn-outline-danger remove-gallery-item">
              <i class="bx bx-trash"></i> Remove
            </button>
          </div>
          <div class="input-group input-group-sm mb-2">
            <span class="input-group-text"><i class="bx bx-link"></i></span>
            <input type="text" name="content[items][${idx}][image]"
                   id="gal_url_${secId}_${idx}"
                   class="form-control" placeholder="https://... or upload">
          </div>
          <label class="btn btn-outline-secondary btn-sm mb-2">
            <i class="bx bx-upload me-1"></i> Upload
            <input type="file" accept="image/jpeg,image/png,image/webp,image/gif"
                   class="d-none gallery-upload"
                   data-section="${secId}" data-index="${idx}"
                   data-url-field="gal_url_${secId}_${idx}">
          </label>
          <input type="text" name="content[items][${idx}][caption]"
                 class="form-control form-control-sm" placeholder="Caption (optional)">
        </div>`;
      document.getElementById('gallery-items-' + secId).insertAdjacentHTML('beforeend', tpl);
      bindRemove();
      setTimeout(bindUploads, 50);
    });
}());
</script>