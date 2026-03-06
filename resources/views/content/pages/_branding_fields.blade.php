{{--
  Shared branding fields partial.
  Requires: $page (Page model)
  Provides: logo, favicon, og_image inputs with media browser buttons.
--}}

{{-- Logo --}}
<div class="mb-4">
  <label class="form-label small fw-semibold">Logo</label>
  @if($page->logo_url)
    <div class="mb-2 p-2 border rounded text-center bg-light" id="logo-current-wrap">
      <img src="{{ $page->logo_url }}" alt="Logo" style="max-height:60px;max-width:100%;object-fit:contain">
    </div>
  @endif
  <div id="logo-preview-wrap" style="display:none" class="mb-2 p-2 border rounded text-center bg-light">
    <img id="logo-preview" src="" style="max-height:60px;max-width:100%;object-fit:contain">
  </div>
  <input type="hidden" name="logo_media" id="logo-media-url" value="">
  <div class="d-flex gap-2 align-items-center">
    <input type="file" name="logo" id="logo-input"
           class="form-control form-control-sm"
           accept="image/jpeg,image/png,image/webp,image/svg+xml">
    <button type="button"
            class="btn btn-sm btn-outline-secondary flex-shrink-0 media-browse-btn"
            data-field="logo-media-url"
            data-preview="logo-preview"
            data-preview-wrap="logo-preview-wrap"
            title="Escoger del Media Manager">
      <i class="bx bx-images"></i>
    </button>
  </div>
  <small class="text-muted">JPG, PNG, WebP, SVG — o escoge del media manager.</small>
</div>

{{-- Favicon --}}
<div class="mb-4">
  <label class="form-label small fw-semibold">Favicon</label>
  @if($page->favicon_url)
    <div class="mb-2 d-flex align-items-center gap-2" id="favicon-current-wrap">
      <img src="{{ $page->favicon_url }}" alt="Favicon" width="32" height="32" style="object-fit:contain">
      <small class="text-muted">Favicon actual</small>
    </div>
  @endif
  <div id="favicon-preview-wrap" style="display:none" class="mb-2 d-flex align-items-center gap-2">
    <img id="favicon-preview" src="" width="32" height="32" style="object-fit:contain">
    <small class="text-muted">Vista previa</small>
  </div>
  <input type="hidden" name="favicon_media" id="favicon-media-url" value="">
  <div class="d-flex gap-2 align-items-center">
    <input type="file" name="favicon" id="favicon-input"
           class="form-control form-control-sm"
           accept=".ico,image/png,image/svg+xml">
    <button type="button"
            class="btn btn-sm btn-outline-secondary flex-shrink-0 media-browse-btn"
            data-field="favicon-media-url"
            data-preview="favicon-preview"
            data-preview-wrap="favicon-preview-wrap"
            title="Escoger del Media Manager">
      <i class="bx bx-images"></i>
    </button>
  </div>
  <small class="text-muted">ICO, PNG o SVG (32×32px recomendado) — o escoge del media manager.</small>
</div>
