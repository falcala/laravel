@php $c = $section->content; @endphp

<div class="row g-3">

  <div class="col-12">
    <label class="form-label small fw-semibold">Heading</label>
    <input type="text" name="content[heading]" class="form-control form-control-sm"
           value="{{ $c['heading'] ?? '' }}">
  </div>

  <div class="col-12">
    <label class="form-label small fw-semibold">Subheading</label>
    <input type="text" name="content[subheading]" class="form-control form-control-sm"
           value="{{ $c['subheading'] ?? '' }}">
  </div>

  <div class="col-md-6">
    <label class="form-label small fw-semibold">Button Text</label>
    <input type="text" name="content[button_text]" class="form-control form-control-sm"
           value="{{ $c['button_text'] ?? 'Get Started' }}">
  </div>

  <div class="col-md-6">
    <label class="form-label small fw-semibold">Button URL</label>
    <input type="text" name="content[button_url]" class="form-control form-control-sm"
           value="{{ $c['button_url'] ?? '#' }}">
  </div>

  <div class="col-md-4">
    <label class="form-label small fw-semibold">Alignment</label>
    <select name="content[align]" class="form-select form-select-sm">
      @foreach(['left' => 'Left', 'center' => 'Center', 'right' => 'Right'] as $val => $lbl)
        <option value="{{ $val }}" {{ ($c['align'] ?? 'center') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
      @endforeach
    </select>
  </div>

  {{-- Color pickers --}}
  @php
    $colorFields = [
      'bg_color'     => 'Background Color',
      'text_color'   => 'Text Color',
      'button_bg'    => 'Button Background',
      'button_color' => 'Button Text Color',
    ];
    $colorDefaults = [
      'bg_color'     => '#696cff',
      'text_color'   => '#ffffff',
      'button_bg'    => '#ffffff',
      'button_color' => '#696cff',
    ];
  @endphp
  @foreach($colorFields as $field => $label)
  <div class="col-md-3">
    <label class="form-label small fw-semibold">{{ $label }}</label>
    <div class="d-flex gap-1">
      <input type="color"
             name="content[{{ $field }}]"
             id="cta_{{ $field }}_{{ $section->id }}"
             class="form-control form-control-color"
             value="{{ $c[$field] ?? $colorDefaults[$field] }}"
             style="width:38px;height:31px">
      <input type="text"
             name="content[{{ $field }}_hex]"
             id="cta_{{ $field }}_hex_{{ $section->id }}"
             class="form-control form-control-sm"
             value="{{ $c[$field] ?? $colorDefaults[$field] }}">
    </div>
  </div>
  @endforeach

  {{-- Live preview --}}
  <div class="col-12">
    <label class="form-label small fw-semibold">Preview</label>
    <div id="cta-preview-{{ $section->id }}"
         class="rounded p-4"
         style="
           background-color:{{ $c['bg_color'] ?? '#696cff' }};
           text-align:{{ $c['align'] ?? 'center' }};
         ">
      <div id="cta-prev-heading-{{ $section->id }}"
           style="color:{{ $c['text_color'] ?? '#ffffff' }};font-size:1.5rem;font-weight:700;margin-bottom:.5rem">
        {{ $c['heading'] ?? 'Ready to get started?' }}
      </div>
      <div id="cta-prev-sub-{{ $section->id }}"
           style="color:{{ $c['text_color'] ?? '#ffffff' }};margin-bottom:1rem;opacity:.9">
        {{ $c['subheading'] ?? 'Join thousands of happy customers today.' }}
      </div>
      <button type="button" id="cta-prev-btn-{{ $section->id }}"
              class="btn btn-sm px-4 py-2"
              style="background-color:{{ $c['button_bg'] ?? '#ffffff' }};color:{{ $c['button_color'] ?? '#696cff' }};border:none">
        {{ $c['button_text'] ?? 'Get Started' }}
      </button>
    </div>
  </div>

</div>

<script>
(function () {
  var id = '{{ $section->id }}';

  function g(sel) { return document.getElementById(sel); }
  function q(n)   { return document.querySelector('[name="content[' + n + ']"]'); }

  var prevWrap    = g('cta-preview-'     + id);
  var prevHeading = g('cta-prev-heading-'+ id);
  var prevSub     = g('cta-prev-sub-'   + id);
  var prevBtn     = g('cta-prev-btn-'   + id);

  function update() {
    var bg    = g('cta_bg_color_hex_'    + id)?.value || '#696cff';
    var tc    = g('cta_text_color_hex_'  + id)?.value || '#ffffff';
    var bbg   = g('cta_button_bg_hex_'   + id)?.value || '#ffffff';
    var bc    = g('cta_button_color_hex_'+ id)?.value || '#696cff';
    var align = q('align')?.value || 'center';

    prevWrap.style.backgroundColor = bg;
    prevWrap.style.textAlign       = align;
    prevHeading.style.color        = tc;
    prevSub.style.color            = tc;
    prevBtn.style.backgroundColor  = bbg;
    prevBtn.style.color            = bc;
    prevHeading.textContent        = q('heading')?.value    || 'Ready to get started?';
    prevSub.textContent            = q('subheading')?.value || 'Join thousands of happy customers today.';
    prevBtn.textContent            = q('button_text')?.value || 'Get Started';
  }

  // Sync color picker ↔ hex text
  ['bg_color','text_color','button_bg','button_color'].forEach(function (field) {
    var picker = g('cta_' + field + '_'     + id);
    var hex    = g('cta_' + field + '_hex_' + id);
    if (!picker || !hex) return;
    picker.addEventListener('input', function () { hex.value = picker.value; update(); });
    hex.addEventListener('input', function () {
      if (/^#[0-9a-fA-F]{6}$/.test(hex.value)) picker.value = hex.value;
      update();
    });
  });

  // Text / select fields
  ['heading','subheading','button_text','button_url','align'].forEach(function (f) {
    var el = q(f);
    if (el) el.addEventListener('input', update);
    if (el) el.addEventListener('change', update);
  });

  update();
}());
</script>