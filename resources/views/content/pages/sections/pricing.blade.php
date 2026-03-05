@php $plans = $section->content['plans'] ?? []; @endphp

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

<div id="pricing-plans">
  @foreach($plans as $i => $plan)
  <div class="border rounded p-3 mb-2 plan-item {{ ($plan['highlighted'] ?? false) ? 'border-primary' : '' }}">
    <div class="d-flex justify-content-between mb-2">
      <strong>Plan {{ $i + 1 }}</strong>
      <button type="button" class="btn btn-sm btn-outline-danger remove-plan"><i class="bx bx-trash"></i></button>
    </div>
    <div class="row g-2">
      <div class="col-6">
        <label class="form-label small">Plan Name</label>
        <input type="text" name="content[plans][{{ $i }}][name]"
               class="form-control form-control-sm" value="{{ $plan['name'] ?? '' }}" />
      </div>
      <div class="col-3">
        <label class="form-label small">Price</label>
        <input type="text" name="content[plans][{{ $i }}][price]"
               class="form-control form-control-sm" value="{{ $plan['price'] ?? '0' }}" />
      </div>
      <div class="col-3">
        <label class="form-label small">Period</label>
        <input type="text" name="content[plans][{{ $i }}][period]"
               class="form-control form-control-sm" value="{{ $plan['period'] ?? 'mo' }}" />
      </div>
      <div class="col-8">
        <label class="form-label small">Button Text</label>
        <input type="text" name="content[plans][{{ $i }}][button_text]"
               class="form-control form-control-sm" value="{{ $plan['button_text'] ?? 'Get Started' }}" />
      </div>
      <div class="col-4 d-flex align-items-end pb-1">
        <div class="form-check">
          <input class="form-check-input" type="checkbox"
                 name="content[plans][{{ $i }}][highlighted]" value="1"
                 {{ ($plan['highlighted'] ?? false) ? 'checked' : '' }}>
          <label class="form-check-label small">Highlight</label>
        </div>
      </div>
      <div class="col-12">
        <label class="form-label small">Features (one per line)</label>
        <textarea name="content[plans][{{ $i }}][features_text]"
                  class="form-control form-control-sm" rows="3">{{ implode("\n", $plan['features'] ?? []) }}</textarea>
      </div>
    </div>
  </div>
  @endforeach
</div>

<button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1" id="add-plan">
  <i class="bx bx-plus me-1"></i> Add Plan
</button>

<script>
(function() {
  let count = {{ count($plans) }};
  document.getElementById('add-plan').addEventListener('click', () => {
    const tpl = `<div class="border rounded p-3 mb-2 plan-item">
      <div class="d-flex justify-content-between mb-2">
        <strong>Plan ${count + 1}</strong>
        <button type="button" class="btn btn-sm btn-outline-danger remove-plan"><i class="bx bx-trash"></i></button>
      </div>
      <div class="row g-2">
        <div class="col-6"><label class="form-label small">Plan Name</label>
          <input type="text" name="content[plans][${count}][name]" class="form-control form-control-sm" /></div>
        <div class="col-3"><label class="form-label small">Price</label>
          <input type="text" name="content[plans][${count}][price]" class="form-control form-control-sm" value="0" /></div>
        <div class="col-3"><label class="form-label small">Period</label>
          <input type="text" name="content[plans][${count}][period]" class="form-control form-control-sm" value="mo" /></div>
        <div class="col-8"><label class="form-label small">Button Text</label>
          <input type="text" name="content[plans][${count}][button_text]" class="form-control form-control-sm" value="Get Started" /></div>
        <div class="col-4 d-flex align-items-end pb-1">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="content[plans][${count}][highlighted]" value="1">
            <label class="form-check-label small">Highlight</label>
          </div>
        </div>
        <div class="col-12"><label class="form-label small">Features (one per line)</label>
          <textarea name="content[plans][${count}][features_text]" class="form-control form-control-sm" rows="3"></textarea></div>
      </div></div>`;
    document.getElementById('pricing-plans').insertAdjacentHTML('beforeend', tpl);
    count++;
    bindRemove();
  });
  function bindRemove() {
    document.querySelectorAll('.remove-plan').forEach(b => b.onclick = () => b.closest('.plan-item').remove());
  }
  bindRemove();
})();
</script>