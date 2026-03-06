@php $c = $section->content ?? []; @endphp

<div class="row g-3">

  {{-- ── Datos personales ─────────────────────────────────────────── --}}
  <div class="col-12">
    <div class="card border mb-0">
      <div class="card-header py-2 bg-light">
        <strong class="small"><i class="bx bx-user me-1"></i> Datos personales</strong>
      </div>
      <div class="card-body">
        <div class="row g-2">

          <div class="col-md-6">
            <label class="form-label small">Foto / Avatar (URL)</label>
            <div class="d-flex align-items-center gap-2">
              <div id="vc-photo-preview-{{ $section->id }}"
                   class="rounded-circle border overflow-hidden flex-shrink-0"
                   style="width:44px;height:44px;background:#f0f0ff">
                @if(!empty($c['photo_url']))
                  <img src="{{ $c['photo_url'] }}" class="w-100 h-100" style="object-fit:cover">
                @else
                  <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                    <i class="bx bx-user text-muted"></i>
                  </div>
                @endif
              </div>
              <div class="flex-grow-1">
                <input type="text" name="content[photo_url]"
                       id="vc-photo-url-{{ $section->id }}"
                       class="form-control form-control-sm"
                       value="{{ $c['photo_url'] ?? '' }}"
                       placeholder="https://...">
              </div>
              <button type="button"
                      class="btn btn-outline-primary btn-sm media-browse-btn flex-shrink-0"
                      data-field="vc-photo-url-{{ $section->id }}"
                      data-preview="vc-photo-img-{{ $section->id }}"
                      data-preview-wrap="vc-photo-preview-{{ $section->id }}">
                <i class="bx bx-images"></i>
              </button>
            </div>
          </div>

          <div class="col-md-3">
            <label class="form-label small">Nombre</label>
            <input type="text" name="content[first_name]" class="form-control form-control-sm"
                   value="{{ $c['first_name'] ?? '' }}" placeholder="John">
          </div>
          <div class="col-md-3">
            <label class="form-label small">Apellido</label>
            <input type="text" name="content[last_name]" class="form-control form-control-sm"
                   value="{{ $c['last_name'] ?? '' }}" placeholder="Doe">
          </div>

          <div class="col-md-6">
            <label class="form-label small">Empresa / Organización</label>
            <input type="text" name="content[organization]" class="form-control form-control-sm"
                   value="{{ $c['organization'] ?? '' }}" placeholder="Mi Empresa S.A.">
          </div>
          <div class="col-md-6">
            <label class="form-label small">Cargo / Título</label>
            <input type="text" name="content[title]" class="form-control form-control-sm"
                   value="{{ $c['title'] ?? '' }}" placeholder="Director General">
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- ── Contacto ──────────────────────────────────────────────────── --}}
  <div class="col-12">
    <div class="card border mb-0">
      <div class="card-header py-2 bg-light">
        <strong class="small"><i class="bx bx-phone me-1"></i> Contacto</strong>
      </div>
      <div class="card-body">
        <div class="row g-2">

          <div class="col-md-6">
            <label class="form-label small">Teléfono Celular</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bx bx-mobile"></i></span>
              <input type="text" name="content[phone_mobile]" class="form-control"
                     value="{{ $c['phone_mobile'] ?? '' }}" placeholder="+52 55 1234 5678">
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label small">Teléfono Trabajo</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bx bx-phone"></i></span>
              <input type="text" name="content[phone_work]" class="form-control"
                     value="{{ $c['phone_work'] ?? '' }}" placeholder="+52 55 9876 5432">
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label small">Email</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bx bx-envelope"></i></span>
              <input type="email" name="content[email]" class="form-control"
                     value="{{ $c['email'] ?? '' }}" placeholder="correo@ejemplo.com">
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label small">Sitio Web</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bx bx-globe"></i></span>
              <input type="url" name="content[website]" class="form-control"
                     value="{{ $c['website'] ?? '' }}" placeholder="https://ejemplo.com">
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- ── Dirección ─────────────────────────────────────────────────── --}}
  <div class="col-12">
    <div class="card border mb-0">
      <div class="card-header py-2 bg-light">
        <strong class="small"><i class="bx bx-map me-1"></i> Dirección (opcional)</strong>
      </div>
      <div class="card-body">
        <div class="row g-2">
          <div class="col-12">
            <label class="form-label small">Calle y número</label>
            <input type="text" name="content[address]" class="form-control form-control-sm"
                   value="{{ $c['address'] ?? '' }}" placeholder="Av. Reforma 123, Col. Centro">
          </div>
          <div class="col-md-4">
            <label class="form-label small">Ciudad</label>
            <input type="text" name="content[city]" class="form-control form-control-sm"
                   value="{{ $c['city'] ?? '' }}" placeholder="Ciudad de México">
          </div>
          <div class="col-md-3">
            <label class="form-label small">Estado / Provincia</label>
            <input type="text" name="content[state]" class="form-control form-control-sm"
                   value="{{ $c['state'] ?? '' }}" placeholder="CDMX">
          </div>
          <div class="col-md-2">
            <label class="form-label small">C.P.</label>
            <input type="text" name="content[zip]" class="form-control form-control-sm"
                   value="{{ $c['zip'] ?? '' }}" placeholder="06600">
          </div>
          <div class="col-md-3">
            <label class="form-label small">País (código)</label>
            <input type="text" name="content[country]" class="form-control form-control-sm"
                   value="{{ $c['country'] ?? 'MX' }}" placeholder="MX" maxlength="3">
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Redes sociales ────────────────────────────────────────────── --}}
  <div class="col-12">
    <div class="card border mb-0">
      <div class="card-header py-2 bg-light">
        <strong class="small"><i class="bx bx-share-alt me-1"></i> Redes sociales (opcional)</strong>
      </div>
      <div class="card-body">
        <div class="row g-2">
          <div class="col-md-4">
            <label class="form-label small">LinkedIn (URL)</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bxl-linkedin"></i></span>
              <input type="url" name="content[linkedin]" class="form-control"
                     value="{{ $c['linkedin'] ?? '' }}" placeholder="https://linkedin.com/in/...">
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-label small">Twitter / X (URL)</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bxl-twitter"></i></span>
              <input type="url" name="content[twitter]" class="form-control"
                     value="{{ $c['twitter'] ?? '' }}" placeholder="https://twitter.com/...">
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-label small">Instagram (URL)</label>
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bxl-instagram"></i></span>
              <input type="url" name="content[instagram]" class="form-control"
                     value="{{ $c['instagram'] ?? '' }}" placeholder="https://instagram.com/...">
            </div>
          </div>
          <div class="col-12">
            <label class="form-label small">Nota</label>
            <textarea name="content[note]" class="form-control form-control-sm" rows="2"
                      placeholder="Nota adicional en la vCard…">{{ $c['note'] ?? '' }}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Apariencia de la tarjeta ──────────────────────────────────── --}}
  <div class="col-12">
    <div class="card border mb-0">
      <div class="card-header py-2 bg-light">
        <strong class="small"><i class="bx bx-palette me-1"></i> Apariencia</strong>
      </div>
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label small">Color de fondo</label>
            <div class="d-flex gap-2">
              <input type="color" name="content[bg_color]"
                     class="form-control form-control-color"
                     value="{{ $c['bg_color'] ?? '#696cff' }}"
                     style="width:46px;height:38px">
              <input type="text" name="content[bg_color_hex]"
                     class="form-control form-control-sm"
                     value="{{ $c['bg_color'] ?? '#696cff' }}">
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-label small">Color de texto</label>
            <div class="d-flex gap-2">
              <input type="color" name="content[text_color]"
                     class="form-control form-control-color"
                     value="{{ $c['text_color'] ?? '#ffffff' }}"
                     style="width:46px;height:38px">
              <input type="text" name="content[text_color_hex]"
                     class="form-control form-control-sm"
                     value="{{ $c['text_color'] ?? '#ffffff' }}">
            </div>
          </div>
          <div class="col-md-4">
            <label class="form-label small">Texto del botón</label>
            <input type="text" name="content[btn_label]" class="form-control form-control-sm"
                   value="{{ $c['btn_label'] ?? 'Guardar Contacto' }}"
                   placeholder="Guardar Contacto">
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
(function () {
  // Sync color pickers with hex inputs
  function syncColor(pickerId, hexId) {
    var picker = document.querySelector('[name="' + pickerId + '"]');
    var hex    = document.querySelector('[name="' + hexId + '"]');
    if (!picker || !hex) return;
    picker.addEventListener('input', function () { hex.value = picker.value; });
    hex.addEventListener('input', function () {
      if (/^#[0-9a-fA-F]{6}$/.test(hex.value)) picker.value = hex.value;
    });
  }
  syncColor('content[bg_color]',   'content[bg_color_hex]');
  syncColor('content[text_color]', 'content[text_color_hex]');
}());
</script>
