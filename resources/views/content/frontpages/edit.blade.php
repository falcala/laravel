@extends('layouts/contentNavbarLayout')

@section('title', 'Front Page — ' . $pageOwner->name)

@section('vendor-style')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<style>
  .section-card { background:#fff; border:1px solid #d9dee3; border-radius:8px; margin-bottom:12px; transition:box-shadow .2s; }
  .section-card.sortable-ghost { opacity:.4; background:#e7e7ff; }
  .section-card.sortable-chosen { box-shadow:0 4px 18px rgba(105,108,255,.25); }
  .drag-handle { cursor:grab; padding:0 10px; color:#a1acb8; font-size:22px; user-select:none; }
  .drag-handle:active { cursor:grabbing; }
  .section-header { display:flex; align-items:center; padding:14px 16px; gap:12px; }
  .section-body { display:none; border-top:1px solid #d9dee3; padding:20px; background:#f8f8ff; border-radius:0 0 8px 8px; }
  .section-body.open { display:block; }
  .section-type-badge { padding:6px 8px; border-radius:6px; background:rgba(105,108,255,.1); color:#696cff; }
</style>
@endsection

@section('content')
<div class="row">

  {{-- Left: Sections --}}
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
          <h5 class="mb-0">
            <i class="bx bx-layout me-2"></i>Front Page
            @if(auth()->id() !== $pageOwner->id)
              <span class="text-muted fw-normal small ms-1">de {{ $pageOwner->name }}</span>
            @endif
          </h5>
          @if($pageOwner->nickname)
            <small class="text-muted">
              URL:
              <a href="{{ route('frontpages.show', $pageOwner->nickname) }}" target="_blank" class="text-primary">
                /u/{{ $pageOwner->nickname }}
              </a>
            </small>
          @else
            <small class="text-warning"><i class="bx bx-error-circle me-1"></i>Este usuario no tiene nickname — la URL pública no estará disponible.</small>
          @endif
        </div>
        <div class="d-flex gap-2">
          @if($pageOwner->nickname)
          <a href="{{ route('frontpages.show', $pageOwner->nickname) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-link-external me-1"></i> Preview
          </a>
          @endif
          @can('frontpages.manage')
            @if(auth()->id() !== $pageOwner->id)
            <a href="{{ route('frontpages.index') }}" class="btn btn-sm btn-outline-secondary">
              <i class="bx bx-arrow-back me-1"></i> Volver
            </a>
            @endif
          @endcan
        </div>
      </div>
      <div class="card-body">

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        @endif

        <div id="sections-list">
          @forelse($sections as $section)
          <div class="section-card" data-id="{{ $section->id }}">

            <div class="section-header">
              <span class="drag-handle"><i class="bx bx-grid-vertical"></i></span>

              <span class="section-type-badge">
                <i class="bx {{ $types[$section->type]['icon'] }}"></i>
              </span>

              <div class="flex-grow-1">
                <div class="fw-semibold">{{ $section->title }}</div>
                <small class="text-muted">{{ $types[$section->type]['label'] }}</small>
              </div>

              <span class="badge {{ $section->is_visible ? 'bg-label-success' : 'bg-label-secondary' }} me-1">
                {{ $section->is_visible ? 'Visible' : 'Oculta' }}
              </span>

              <button type="button" class="btn btn-sm btn-outline-primary me-1 toggle-section-btn"
                      data-target="body-{{ $section->id }}">
                <i class="bx bx-edit"></i> Editar
              </button>

              <form action="{{ route('frontpages.sections.toggle', $section) }}" method="POST" class="d-inline me-1">
                @csrf
                <button type="submit"
                        class="btn btn-sm {{ $section->is_visible ? 'btn-outline-warning' : 'btn-outline-success' }}"
                        title="{{ $section->is_visible ? 'Ocultar' : 'Mostrar' }}">
                  <i class="bx {{ $section->is_visible ? 'bx-hide' : 'bx-show' }}"></i>
                </button>
              </form>

              <form action="{{ route('frontpages.sections.delete', $section) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Eliminar esta sección?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="bx bx-trash"></i>
                </button>
              </form>
            </div>

            <div class="section-body" id="body-{{ $section->id }}">
              <form action="{{ route('frontpages.sections.update', $section) }}" method="POST">
                @csrf

                <div class="row mb-3">
                  <div class="col-md-8">
                    <label class="form-label">Título de la sección</label>
                    <input type="text" name="title" class="form-control" value="{{ $section->title }}" />
                  </div>
                  <div class="col-md-4 d-flex align-items-end pb-1">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="is_visible" value="1"
                             {{ $section->is_visible ? 'checked' : '' }}>
                      <label class="form-check-label">Visible</label>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label small fw-semibold">
                    ID / Anchor <span class="text-muted fw-normal">(para menú de navegación)</span>
                  </label>
                  <div class="input-group input-group-sm">
                    <span class="input-group-text text-muted">#</span>
                    <input type="text" name="anchor" class="form-control font-monospace anchor-input"
                           value="{{ $section->anchor }}"
                           placeholder="mi-seccion"
                           pattern="[a-z0-9_-]+"
                           title="Solo letras minúsculas, números, guiones y guión bajo">
                  </div>
                  <small class="text-muted">Letras, números, <code>-</code> y <code>_</code>. Usa <code>#mi-seccion</code> como URL en el menú.</small>
                </div>

                @include('content.pages.sections.' . $section->type, ['section' => $section])

                <div class="mt-3 pt-3 border-top">
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bx bx-save me-1"></i> Guardar sección
                  </button>
                  <button type="button" class="btn btn-secondary btn-sm ms-1 toggle-section-btn"
                          data-target="body-{{ $section->id }}">
                    Cancelar
                  </button>
                </div>
              </form>
            </div>

          </div>
          @empty
          <div class="text-center text-muted py-5">
            <i class="bx bx-layout fs-1 d-block mb-2"></i>
            Sin secciones todavía. Agrega una desde el panel derecho.
          </div>
          @endforelse
        </div>

      </div>
    </div>
  </div>

  {{-- Right sidebar --}}
  <div class="col-lg-4">

    {{-- Page Settings --}}
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Configuración de la página</h6>
      </div>
      <div class="card-body p-0">

        <ul class="nav nav-tabs flex-wrap border-bottom px-3 pt-2" id="settingsTabs">
          <li class="nav-item flex-fill">
            <a class="nav-link active small text-center" href="#" data-tab="tab-general">
              <i class="bx bx-cog me-1"></i>General
            </a>
          </li>
          <li class="nav-item flex-fill">
            <a class="nav-link small text-center" href="#" data-tab="tab-branding">
              <i class="bx bx-image me-1"></i>Branding
            </a>
          </li>
          <li class="nav-item flex-fill">
            <a class="nav-link small text-center" href="#" data-tab="tab-seo">
              <i class="bx bx-search-alt me-1"></i>SEO
            </a>
          </li>
          <li class="nav-item flex-fill">
            <a class="nav-link small text-center" href="#" data-tab="tab-social">
              <i class="bx bx-share-alt me-1"></i>Social
            </a>
          </li>
        </ul>

        <form action="{{ route('frontpages.update', $pageOwner) }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- General --}}
          <div class="tab-panel p-3" id="tab-general">
            <div class="mb-3">
              <label class="form-label small">Título de página <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control form-control-sm"
                     value="{{ $page->title }}" required />
            </div>
            <div class="mb-3">
              <label class="form-label small">Meta descripción</label>
              <textarea name="meta_description" class="form-control form-control-sm"
                        rows="2" maxlength="500">{{ $page->meta_description }}</textarea>
            </div>
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_published" value="1"
                       {{ $page->is_published ? 'checked' : '' }}>
                <label class="form-check-label small">Publicada</label>
              </div>
              <small class="text-muted">Si no está publicada solo el dueño puede verla.</small>
            </div>
          </div>

          {{-- Branding --}}
          <div class="tab-panel p-3" id="tab-branding" style="display:none">
            @include('content.pages._branding_fields')
          </div>

          {{-- SEO --}}
          <div class="tab-panel p-3" id="tab-seo" style="display:none">
            <div class="mb-3">
              <label class="form-label small fw-semibold">
                SEO Title
                <span class="float-end text-muted" id="seo-title-count">0/70</span>
              </label>
              <input type="text" name="seo_title" id="seo-title-input" class="form-control form-control-sm"
                     value="{{ $page->seo_title }}" maxlength="70" placeholder="Sobreescribe el título en buscadores">
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">
                SEO Description
                <span class="float-end text-muted" id="seo-desc-count">0/160</span>
              </label>
              <textarea name="seo_description" id="seo-desc-input" class="form-control form-control-sm"
                        rows="3" maxlength="160">{{ $page->seo_description }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Keywords</label>
              <input type="text" name="seo_keywords" class="form-control form-control-sm"
                     value="{{ $page->seo_keywords }}" placeholder="palabra1, palabra2">
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">URL Canónica</label>
              <input type="url" name="canonical_url" class="form-control form-control-sm"
                     value="{{ $page->canonical_url }}">
            </div>
            @php
              $serpTitleText = $page->seo_title ?: $page->title;
              $serpDescText  = $page->seo_description ?: $page->meta_description;
              $serpUrl       = $page->canonical_url ?: url('/u/' . $pageOwner->nickname);
            @endphp
            <div class="border rounded p-2 bg-light mt-2">
              <small class="text-muted d-block mb-2"><i class="bx bx-search me-1"></i>Vista previa en buscadores</small>
              <div style="font-family:Arial,sans-serif">
                <div id="serp-title" style="color:#1a0dab;font-size:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $serpTitleText }}</div>
                <div style="color:#006621;font-size:13px">{{ $serpUrl }}</div>
                <div id="serp-desc" style="color:#545454;font-size:13px;line-height:1.4">{{ $serpDescText }}</div>
              </div>
            </div>
            <div class="mb-3 mt-3">
              <label class="form-label small fw-semibold">Schema Markup <small class="text-muted fw-normal">(JSON-LD)</small></label>
              <textarea name="schema_markup" class="form-control form-control-sm font-monospace" rows="5">{{ $page->schema_markup ? json_encode($page->schema_markup, JSON_PRETTY_PRINT) : '' }}</textarea>
            </div>
          </div>

          {{-- Social --}}
          <div class="tab-panel p-3" id="tab-social" style="display:none">
            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Title</label>
              <input type="text" name="og_title" class="form-control form-control-sm"
                     value="{{ $page->og_title }}" maxlength="95">
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Description</label>
              <textarea name="og_description" class="form-control form-control-sm" rows="2" maxlength="200">{{ $page->og_description }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Image</label>
              @if($page->og_image_url)
                <div class="mb-2"><img src="{{ $page->og_image_url }}" class="img-fluid rounded" style="max-height:80px"></div>
              @endif
              <div id="og-preview-wrap" style="display:none" class="mb-1">
                <img id="og-preview" src="" class="img-fluid rounded" style="max-height:80px">
              </div>
              <input type="hidden" name="og_image_media" id="og-media-url" value="">
              <div class="d-flex gap-2 align-items-center">
                <input type="file" name="og_image" id="og-image-input" class="form-control form-control-sm"
                       accept="image/jpeg,image/png,image/webp">
                <button type="button"
                        class="btn btn-sm btn-outline-secondary flex-shrink-0 media-browse-btn"
                        data-field="og-media-url"
                        data-preview="og-preview"
                        data-preview-wrap="og-preview-wrap"
                        title="Escoger del Media Manager">
                  <i class="bx bx-images"></i>
                </button>
              </div>
            </div>
            <hr>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Twitter Card</label>
              <select name="twitter_card" class="form-select form-select-sm">
                <option value="summary" {{ ($page->twitter_card ?? '') === 'summary' ? 'selected' : '' }}>Summary</option>
                <option value="summary_large_image" {{ ($page->twitter_card ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>Summary Large Image</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label small fw-semibold">Twitter/X Handle</label>
              <div class="input-group input-group-sm">
                <span class="input-group-text">@</span>
                <input type="text" name="twitter_site" class="form-control"
                       value="{{ ltrim($page->twitter_site ?? '', '@') }}">
              </div>
            </div>
          </div>

          {{-- Save --}}
          <div class="px-3 pb-3 pt-2 border-top">
            <button type="submit" class="btn btn-primary w-100 btn-sm">
              <i class="bx bx-save me-1"></i> Guardar configuración
            </button>
          </div>

        </form>
      </div>
    </div>

    {{-- Add Section --}}
    <div class="card">
      <div class="card-header"><h6 class="mb-0">Agregar sección</h6></div>
      <div class="card-body">
        <form action="{{ route('frontpages.sections.add', $pageOwner) }}" method="POST">
          @csrf
          <div class="row g-2">
            @foreach($types as $typeKey => $typeData)
            <div class="col-6">
              <button type="submit" name="type" value="{{ $typeKey }}"
                      class="btn btn-outline-secondary w-100 d-flex flex-column align-items-center py-3 gap-1">
                <i class="bx {{ $typeData['icon'] }} fs-3"></i>
                <small>{{ $typeData['label'] }}</small>
              </button>
            </div>
            @endforeach
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@include('components.media-manager-modal')
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── Anchor slug auto-clean ────────────────────────────────────────
  document.querySelectorAll('.anchor-input').forEach(function (input) {
    input.addEventListener('input', function () {
      var pos = this.selectionStart;
      this.value = this.value.toLowerCase().replace(/[^a-z0-9_-]/g, '');
      this.setSelectionRange(pos, pos);
    });
  });

  // ── Section editor toggle ─────────────────────────────────────────
  document.querySelectorAll('.toggle-section-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var body = document.getElementById(btn.getAttribute('data-target'));
      if (body) body.classList.toggle('open');
    });
  });

  // ── Drag & drop reorder ───────────────────────────────────────────
  var list = document.getElementById('sections-list');
  if (list && typeof Sortable !== 'undefined') {
    Sortable.create(list, {
      handle: '.drag-handle',
      animation: 150,
      ghostClass: 'sortable-ghost',
      chosenClass: 'sortable-chosen',
      onEnd: function () {
        var order = Array.from(list.querySelectorAll('.section-card[data-id]'))
                        .map(function (el) { return el.getAttribute('data-id'); });
        fetch('{{ route("frontpages.sections.reorder") }}', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({ order: order })
        }).catch(function (err) { console.error('Reorder error', err); });
      }
    });
  }

  // ── Settings tabs ─────────────────────────────────────────────────
  document.querySelectorAll('#settingsTabs .nav-link').forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelectorAll('#settingsTabs .nav-link').forEach(function (l) { l.classList.remove('active'); });
      document.querySelectorAll('.tab-panel').forEach(function (p) { p.style.display = 'none'; });
      this.classList.add('active');
      var target = document.getElementById(this.getAttribute('data-tab'));
      if (target) target.style.display = '';
    });
  });

  // ── Image previews ────────────────────────────────────────────────
  function bindImagePreview(inputId, previewId, wrapId, clearFieldId) {
    var input = document.getElementById(inputId);
    if (!input) return;
    input.addEventListener('change', function () {
      if (!this.files || !this.files[0]) return;
      if (clearFieldId) { var f = document.getElementById(clearFieldId); if (f) f.value = ''; }
      var reader = new FileReader();
      reader.onload = function (e) {
        var img  = document.getElementById(previewId);
        var wrap = document.getElementById(wrapId);
        if (img)  img.src = e.target.result;
        if (wrap) wrap.style.display = '';
      };
      reader.readAsDataURL(this.files[0]);
    });
  }
  bindImagePreview('logo-input',     'logo-preview',    'logo-preview-wrap',    'logo-media-url');
  bindImagePreview('favicon-input',  'favicon-preview', 'favicon-preview-wrap', 'favicon-media-url');
  bindImagePreview('og-image-input', 'og-preview',      'og-preview-wrap',      'og-media-url');

  // ── SEO character counters ────────────────────────────────────────
  function bindCounter(inputId, counterId) {
    var input   = document.getElementById(inputId);
    var counter = document.getElementById(counterId);
    if (!input || !counter) return;
    function update() {
      var len = input.value.length;
      var max = parseInt(input.getAttribute('maxlength'), 10);
      counter.textContent = len + '/' + max;
      counter.style.color = len > (max * 0.9) ? '#d32f2f' : '';
    }
    input.addEventListener('input', update);
    update();
  }
  bindCounter('seo-title-input', 'seo-title-count');
  bindCounter('seo-desc-input',  'seo-desc-count');

  // ── Live SERP preview ─────────────────────────────────────────────
  var serpTitle     = document.getElementById('serp-title');
  var serpDesc      = document.getElementById('serp-desc');
  var seoTitleInput = document.getElementById('seo-title-input');
  var seoDescInput  = document.getElementById('seo-desc-input');
  var pageTitle     = @json($page->title);
  var pageMeta      = @json($page->meta_description ?? '');
  if (seoTitleInput && serpTitle) {
    seoTitleInput.addEventListener('input', function () { serpTitle.textContent = this.value || pageTitle; });
  }
  if (seoDescInput && serpDesc) {
    seoDescInput.addEventListener('input', function () { serpDesc.textContent = this.value || pageMeta; });
  }

});
</script>

{{-- ── Media Manager ──────────────────────────────────────────────────── --}}
<script>
(function () {
  var mediaIndexUrl   = '{{ route("media.index") }}';
  var mediaDeleteUrl  = '{{ route("media.destroy") }}';
  var mediaUploadUrl  = '{{ route("media.upload") }}';
  var mediaTreeUrl    = '{{ route("media.tree") }}';
  var folderCreateUrl = '{{ route("media.folders.create") }}';
  var folderDeleteUrl = '{{ route("media.folders.delete") }}';
  var csrfToken       = '{{ csrf_token() }}';

  var mmModal     = null;
  var mmTarget    = { fieldId: null, previewId: null, wrapId: null };
  var currentPath = '';

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.media-browse-btn');
    if (!btn) return;
    mmTarget.fieldId   = btn.dataset.field;
    mmTarget.previewId = btn.dataset.preview;
    mmTarget.wrapId    = btn.dataset.previewWrap;
    if (!mmModal) mmModal = new bootstrap.Modal(document.getElementById('mediaManagerModal'));
    currentPath = '';
    mmModal.show();
    loadFolderTree();
    loadMedia('');
  });

  function loadFolderTree() {
    fetch(mediaTreeUrl, { headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } })
      .then(function (r) { return r.json(); })
      .then(function (tree) {
        var el = document.getElementById('mm-folder-tree');
        el.innerHTML = '';
        var root = document.createElement('a');
        root.href = '#'; root.className = 'd-block px-2 py-1 rounded text-decoration-none fw-semibold mm-tree-node';
        root.style.cssText = 'color:#4a4e69;font-size:12px'; root.dataset.path = '';
        root.innerHTML = '<i class="bx bx-hard-drive me-1"></i>assets';
        root.addEventListener('click', function (e) { e.preventDefault(); navigateTo(''); });
        el.appendChild(root);
        if (tree.children && tree.children.length) el.appendChild(buildTreeEl(tree.children, 1));
        updateTreeActive();
      });
  }

  function buildTreeEl(items, depth) {
    var ul = document.createElement('ul'); ul.className = 'list-unstyled mb-0'; ul.style.paddingLeft = (depth * 12) + 'px';
    items.forEach(function (item) {
      var li = document.createElement('li'); var a = document.createElement('a');
      a.href = '#'; a.className = 'd-block px-2 py-1 rounded text-decoration-none mm-tree-node';
      a.style.cssText = 'color:#4a4e69;font-size:12px'; a.dataset.path = item.path;
      a.innerHTML = '<i class="bx bx-folder me-1 text-muted" style="font-size:12px"></i>' + escHtml(item.name);
      a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(item.path); });
      li.appendChild(a);
      if (item.children && item.children.length) li.appendChild(buildTreeEl(item.children, depth + 1));
      ul.appendChild(li);
    });
    return ul;
  }

  function updateTreeActive() {
    document.querySelectorAll('.mm-tree-node').forEach(function (a) {
      var active = a.dataset.path === currentPath;
      a.style.background = active ? '#696cff' : ''; a.style.color = active ? '#fff' : '#4a4e69';
    });
  }

  function navigateTo(path) { currentPath = path; updateTreeActive(); updateBreadcrumb(path); loadMedia(path); }

  function updateBreadcrumb(path) {
    var bc = document.getElementById('mm-breadcrumb'); bc.innerHTML = '';
    var rootLi = document.createElement('li'); rootLi.className = 'breadcrumb-item' + (path === '' ? ' active' : '');
    if (path === '') { rootLi.textContent = 'assets'; } else { var a = document.createElement('a'); a.href = '#'; a.textContent = 'assets'; a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(''); }); rootLi.appendChild(a); }
    bc.appendChild(rootLi);
    if (path !== '') {
      var parts = path.split('/'); var built = '';
      parts.forEach(function (part, idx) {
        built = built ? built + '/' + part : part;
        var li = document.createElement('li'); li.className = 'breadcrumb-item' + (idx === parts.length - 1 ? ' active' : '');
        if (idx === parts.length - 1) { li.textContent = part; } else { var a = document.createElement('a'); a.href = '#'; a.textContent = part; var np = built; a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(np); }); li.appendChild(a); }
        bc.appendChild(li);
      });
    }
  }

  function loadMedia(path) {
    if (path !== undefined) currentPath = path;
    var loading = document.getElementById('mm-loading'); var grid = document.getElementById('mm-grid'); var empty = document.getElementById('mm-empty');
    loading.style.display = ''; loading.className = 'text-center py-5 flex-grow-1 d-flex align-items-center justify-content-center';
    grid.classList.add('d-none'); empty.classList.add('d-none'); empty.classList.remove('d-flex'); grid.innerHTML = '';
    updateBreadcrumb(currentPath);
    fetch(mediaIndexUrl + '?include_dirs=1&type=all&path=' + encodeURIComponent(currentPath), { headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } })
      .then(function (r) { return r.json(); }).then(renderGrid)
      .catch(function () { loading.style.display = 'none'; empty.classList.remove('d-none'); empty.classList.add('d-flex'); });
  }

  function renderGrid(items) {
    var loading = document.getElementById('mm-loading'); var grid = document.getElementById('mm-grid'); var empty = document.getElementById('mm-empty'); var count = document.getElementById('mm-count');
    loading.style.display = 'none'; grid.innerHTML = '';
    if (!items || items.length === 0) { empty.classList.remove('d-none'); empty.classList.add('d-flex'); count.textContent = ''; return; }
    empty.classList.add('d-none'); empty.classList.remove('d-flex'); grid.classList.remove('d-none');
    var imgCount = items.filter(function (i) { return i.type === 'image'; }).length;
    count.textContent = imgCount + ' imagen' + (imgCount !== 1 ? 'es' : '');
    var fileTpl = document.getElementById('mm-card-tpl'); var folderTpl = document.getElementById('mm-folder-card-tpl');
    items.forEach(function (item) {
      if (item.type === 'folder') {
        var clone = folderTpl.content.cloneNode(true); var card = clone.querySelector('.mm-folder');
        card.dataset.path = item.path; card.dataset.name = item.name;
        clone.querySelector('.mm-folder-name').textContent = item.name;
        clone.querySelector('.mm-folder-inner').addEventListener('click', function (e) { if (e.target.closest('.mm-folder-delete-btn')) return; navigateTo(item.path); loadFolderTree(); });
        clone.querySelector('.mm-folder-delete-btn').addEventListener('click', function (e) {
          e.stopPropagation(); if (!confirm('¿Eliminar carpeta "' + item.name + '"?')) return;
          fetch(folderDeleteUrl, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ path: item.path }) })
            .then(function (r) { return r.json(); }).then(function (d) { if (d.success) { loadFolderTree(); loadMedia(currentPath); } });
        });
        var inner = clone.querySelector('.mm-folder-inner');
        inner.addEventListener('mouseenter', function () { inner.querySelector('.mm-folder-delete-btn').style.opacity = '1'; });
        inner.addEventListener('mouseleave', function () { inner.querySelector('.mm-folder-delete-btn').style.opacity = '0'; });
        grid.appendChild(clone);
      } else if (item.type === 'image') {
        var clone = fileTpl.content.cloneNode(true); var card = clone.querySelector('.mm-card');
        card.dataset.name = item.name; clone.querySelector('.mm-card-img').src = item.url; clone.querySelector('.mm-card-name').textContent = item.name;
        var inner = clone.querySelector('.mm-card-inner');
        inner.addEventListener('mouseenter', function () { inner.querySelector('.mm-delete-btn').style.opacity = '1'; inner.querySelector('.mm-select-hint').style.opacity = '1'; });
        inner.addEventListener('mouseleave', function () { inner.querySelector('.mm-delete-btn').style.opacity = '0'; inner.querySelector('.mm-select-hint').style.opacity = '0'; });
        inner.addEventListener('click', function (e) { if (e.target.closest('.mm-delete-btn')) return; selectImage(item.url); });
        clone.querySelector('.mm-delete-btn').addEventListener('click', function (e) {
          e.stopPropagation(); if (!confirm('¿Eliminar "' + item.name + '"?')) return;
          fetch(mediaDeleteUrl, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ name: item.name, path: currentPath }) })
            .then(function (r) { return r.json(); }).then(function (d) { if (d.success) loadMedia(currentPath); });
        });
        grid.appendChild(clone);
      }
    });
  }

  function selectImage(url) {
    var field = document.getElementById(mmTarget.fieldId); if (field) field.value = url;
    var preview = document.getElementById(mmTarget.previewId); if (preview) { preview.src = url; preview.style.display = ''; }
    var wrap = document.getElementById(mmTarget.wrapId); if (wrap) wrap.style.display = '';
    if (mmModal) mmModal.hide();
  }

  document.getElementById('mm-upload-input').addEventListener('change', function () {
    var files = Array.from(this.files); if (!files.length) return;
    var bar = document.getElementById('mm-upload-bar'); var status = document.getElementById('mm-upload-status');
    bar.classList.remove('d-none'); bar.classList.add('d-flex');
    var input = this; var uploaded = 0; var total = files.length;
    files.forEach(function (file) {
      status.textContent = 'Subiendo ' + uploaded + '/' + total + '…';
      var fd = new FormData(); fd.append('file', file); fd.append('_token', csrfToken); fd.append('path', currentPath);
      fetch(mediaUploadUrl, { method: 'POST', body: fd }).then(function (r) { return r.json(); })
        .then(function () {
          uploaded++; if (uploaded === total) { bar.classList.add('d-none'); bar.classList.remove('d-flex'); input.value = ''; loadMedia(currentPath); }
          else status.textContent = 'Subiendo ' + uploaded + '/' + total + '…';
        }).catch(function () { uploaded++; if (uploaded === total) { bar.classList.add('d-none'); bar.classList.remove('d-flex'); } });
    });
  });

  document.getElementById('mm-new-folder-btn').addEventListener('click', function () {
    var name = prompt('Nombre de la nueva carpeta:'); if (!name || !name.trim()) return;
    fetch(folderCreateUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify({ name: name.trim(), path: currentPath }) })
      .then(function (r) { return r.json(); }).then(function (d) { if (d.success) { loadFolderTree(); loadMedia(currentPath); } else alert(d.message || 'Error'); });
  });

  function escHtml(str) { return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
}());
</script>
@endsection
