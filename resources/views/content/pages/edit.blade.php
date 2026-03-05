@extends('layouts/contentNavbarLayout')

@section('title', 'Página de inicio')

@section('vendor-style')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<style>
  .section-card {
    background: #fff;
    border: 1px solid #d9dee3;
    border-radius: 8px;
    margin-bottom: 12px;
    transition: box-shadow .2s;
  }
  .section-card.sortable-ghost {
    opacity: .4;
    background: #e7e7ff;
  }
  .section-card.sortable-chosen {
    box-shadow: 0 4px 18px rgba(105,108,255,.25);
  }
  .drag-handle {
    cursor: grab;
    padding: 0 10px;
    color: #a1acb8;
    font-size: 22px;
    user-select: none;
  }
  .drag-handle:active { cursor: grabbing; }
  .section-header {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    gap: 12px;
  }
  .section-body {
    display: none;
    border-top: 1px solid #d9dee3;
    padding: 20px;
    background: #f8f8ff;
    border-radius: 0 0 8px 8px;
  }
  .section-body.open { display: block; }
  .section-type-badge {
    padding: 6px 8px;
    border-radius: 6px;
    background: rgba(105,108,255,.1);
    color: #696cff;
  }
</style>
@endsection

@section('content')
<div class="row">

  {{-- Left: Sections --}}
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bx bx-layout me-2"></i>Page Sections</h5>
        <a href="{{ route('welcome') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
          <i class="bx bx-link-external me-1"></i> Preview
        </a>
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
                {{ $section->is_visible ? 'Visible' : 'Hidden' }}
              </span>

              <button type="button"
                      class="btn btn-sm btn-outline-primary me-1 toggle-section-btn"
                      data-target="body-{{ $section->id }}">
                <i class="bx bx-edit"></i> Edit
              </button>

              <form action="{{ route('pages.sections.toggle', $section) }}" method="POST" class="d-inline me-1">
                @csrf
                <button type="submit"
                        class="btn btn-sm {{ $section->is_visible ? 'btn-outline-warning' : 'btn-outline-success' }}"
                        title="{{ $section->is_visible ? 'Hide section' : 'Show section' }}">
                  <i class="bx {{ $section->is_visible ? 'bx-hide' : 'bx-show' }}"></i>
                </button>
              </form>

              <form action="{{ route('pages.sections.delete', $section) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this section?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="bx bx-trash"></i>
                </button>
              </form>
            </div>

            <div class="section-body" id="body-{{ $section->id }}">
              <form action="{{ route('pages.sections.update', $section) }}" method="POST">
                @csrf

                <div class="row mb-3">
                  <div class="col-md-8">
                    <label class="form-label">Section Title</label>
                    <input type="text" name="title" class="form-control"
                           value="{{ $section->title }}" />
                  </div>
                  <div class="col-md-4 d-flex align-items-end pb-1">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox"
                             name="is_visible" value="1"
                             {{ $section->is_visible ? 'checked' : '' }}>
                      <label class="form-check-label">Visible</label>
                    </div>
                  </div>
                </div>

                @include('content.pages.sections.' . $section->type, ['section' => $section])

                <div class="mt-3 pt-3 border-top">
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bx bx-save me-1"></i> Save Section
                  </button>
                  <button type="button"
                          class="btn btn-secondary btn-sm ms-1 toggle-section-btn"
                          data-target="body-{{ $section->id }}">
                    Cancel
                  </button>
                </div>
              </form>
            </div>

          </div>
          @empty
          <div class="text-center text-muted py-5">
            <i class="bx bx-layout fs-1 d-block mb-2"></i>
            No sections yet. Add one from the panel on the right.
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
        <h6 class="mb-0">Page Settings</h6>
      </div>
      <div class="card-body p-0">

        <ul class="nav nav-tabs nav-fill border-bottom px-3 pt-2" id="settingsTabs">
          <li class="nav-item">
            <a class="nav-link active small" href="#" data-tab="tab-general">
              <i class="bx bx-cog me-1"></i>General
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link small" href="#" data-tab="tab-branding">
              <i class="bx bx-image me-1"></i>Branding
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link small" href="#" data-tab="tab-seo">
              <i class="bx bx-search-alt me-1"></i>SEO
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link small" href="#" data-tab="tab-social">
              <i class="bx bx-share-alt me-1"></i>Social
            </a>
          </li>
        </ul>

        <form action="{{ route('pages.update') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- General --}}
          <div class="tab-panel p-3" id="tab-general">
            <div class="mb-3">
              <label class="form-label small">Page Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control form-control-sm"
                     value="{{ $page->title }}" required />
            </div>
            <div class="mb-3">
              <label class="form-label small">Meta Description</label>
              <textarea name="meta_description" class="form-control form-control-sm"
                        rows="2" maxlength="500">{{ $page->meta_description }}</textarea>
              <small class="text-muted">Used as fallback SEO description.</small>
            </div>
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       name="is_published" value="1"
                       {{ $page->is_published ? 'checked' : '' }}>
                <label class="form-check-label small">Published</label>
              </div>
            </div>
          </div>

          {{-- Branding --}}
          <div class="tab-panel p-3" id="tab-branding" style="display:none">

            <div class="mb-4">
              <label class="form-label small fw-semibold">Logo</label>
              @if($page->logo_url)
                <div class="mb-2 p-2 border rounded text-center bg-light">
                  <img src="{{ $page->logo_url }}" alt="Logo"
                       style="max-height:60px;max-width:100%;object-fit:contain">
                </div>
              @endif
              <div id="logo-preview-wrap" style="display:none" class="mb-1">
                <img id="logo-preview" src=""
                     class="img-fluid border rounded p-1"
                     style="max-height:60px;object-fit:contain">
              </div>
              <input type="file" name="logo" id="logo-input"
                     class="form-control form-control-sm"
                     accept="image/jpeg,image/png,image/webp,image/svg+xml">
              <small class="text-muted">JPG, PNG, WebP or SVG. Max 2MB.</small>
            </div>

            <div class="mb-4">
              <label class="form-label small fw-semibold">Favicon</label>
              @if($page->favicon_url)
                <div class="mb-2 d-flex align-items-center gap-2">
                  <img src="{{ $page->favicon_url }}" alt="Favicon"
                       width="32" height="32" style="object-fit:contain">
                  <small class="text-muted">Current favicon</small>
                </div>
              @endif
              <div id="favicon-preview-wrap" style="display:none" class="mb-1 d-flex align-items-center gap-2">
                <img id="favicon-preview" src="" width="32" height="32" style="object-fit:contain">
                <small class="text-muted">New favicon preview</small>
              </div>
              <input type="file" name="favicon" id="favicon-input"
                     class="form-control form-control-sm"
                     accept=".ico,image/png,image/svg+xml">
              <small class="text-muted">ICO, PNG or SVG. Max 512KB. Recommended: 32×32px.</small>
            </div>

          </div>

          {{-- SEO --}}
          <div class="tab-panel p-3" id="tab-seo" style="display:none">

            <div class="mb-3">
              <label class="form-label small fw-semibold">
                SEO Title
                <span class="float-end text-muted" id="seo-title-count">0/70</span>
              </label>
              <input type="text" name="seo_title" id="seo-title-input"
                     class="form-control form-control-sm"
                     value="{{ $page->seo_title }}"
                     maxlength="70"
                     placeholder="Overrides page title in search results">
              <small class="text-muted">Recommended: 50–60 characters.</small>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">
                SEO Description
                <span class="float-end text-muted" id="seo-desc-count">0/160</span>
              </label>
              <textarea name="seo_description" id="seo-desc-input"
                        class="form-control form-control-sm" rows="3"
                        maxlength="160"
                        placeholder="Shown in search engine results">{{ $page->seo_description }}</textarea>
              <small class="text-muted">Recommended: 150–160 characters.</small>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Keywords</label>
              <input type="text" name="seo_keywords"
                     class="form-control form-control-sm"
                     value="{{ $page->seo_keywords }}"
                     placeholder="laravel, admin, dashboard">
              <small class="text-muted">Comma-separated. Minor ranking factor today.</small>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Canonical URL</label>
              <input type="url" name="canonical_url"
                     class="form-control form-control-sm"
                     value="{{ $page->canonical_url }}"
                     placeholder="https://yourdomain.com/">
              <small class="text-muted">Prevents duplicate content issues.</small>
            </div>

            {{-- SERP Preview --}}
            @php
              $serpTitleText = $page->seo_title ?: $page->title;
              $serpDescText  = $page->seo_description ?: $page->meta_description;
              $serpUrl       = $page->canonical_url ?: url('/');
            @endphp
            <div class="border rounded p-2 bg-light mt-2">
              <small class="text-muted d-block mb-2">
                <i class="bx bx-search me-1"></i>Search Result Preview
              </small>
              <div style="font-family:Arial,sans-serif">
                <div id="serp-title"
                     style="color:#1a0dab;font-size:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                  {{ $serpTitleText }}
                </div>
                <div style="color:#006621;font-size:13px">
                  {{ $serpUrl }}
                </div>
                <div id="serp-desc" style="color:#545454;font-size:13px;line-height:1.4;overflow:hidden">
                  {{ $serpDescText }}
                </div>
              </div>
            </div>
            <div class="mb-3 mt-3">
              <label class="form-label small fw-semibold">
                Schema Markup <small class="text-muted fw-normal">(JSON-LD)</small>
              </label>
              <textarea name="schema_markup"
                        class="form-control form-control-sm font-monospace"
                        rows="5"
                        placeholder=''>
						{{ $page->schema_markup ? json_encode($page->schema_markup, JSON_PRETTY_PRINT) : '' }}</textarea>
              <small class="text-muted">Optional structured data for rich search results.</small>
            </div>
          </div>

          {{-- Social --}}
          <div class="tab-panel p-3" id="tab-social" style="display:none">

            <p class="small text-muted mb-3">
              Controls how your page appears when shared on social platforms.
            </p>

            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Title</label>
              <input type="text" name="og_title"
                     class="form-control form-control-sm"
                     value="{{ $page->og_title }}"
                     maxlength="95"
                     placeholder="Leave blank to use SEO title">
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Description</label>
              <textarea name="og_description"
                        class="form-control form-control-sm" rows="2"
                        maxlength="200"
                        placeholder="Leave blank to use SEO description">{{ $page->og_description }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Image</label>
              @if($page->og_image_url)
                <div class="mb-2">
                  <img src="{{ $page->og_image_url }}" alt="OG Image"
                       class="img-fluid rounded" style="max-height:80px">
                </div>
              @endif
              <div id="og-preview-wrap" style="display:none" class="mb-1">
                <img id="og-preview" src=""
                     class="img-fluid rounded" style="max-height:80px">
              </div>
              <input type="file" name="og_image" id="og-image-input"
                     class="form-control form-control-sm"
                     accept="image/jpeg,image/png,image/webp">
              <small class="text-muted">Recommended: 1200×630px. Max 2MB.</small>
            </div>

            <hr>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Twitter Card Type</label>
              <select name="twitter_card" class="form-select form-select-sm">
                <option value="summary"
                  {{ ($page->twitter_card ?? '') === 'summary' ? 'selected' : '' }}>
                  Summary (small image)
                </option>
                <option value="summary_large_image"
                  {{ ($page->twitter_card ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>
                  Summary Large Image
                </option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Twitter/X Handle</label>
              <div class="input-group input-group-sm">
                <span class="input-group-text">@</span>
                <input type="text" name="twitter_site"
                       class="form-control"
                       value="{{ ltrim($page->twitter_site ?? '', '@') }}"
                       placeholder="yourusername">
              </div>
            </div>

            <div class="border rounded overflow-hidden mt-3">
              <small class="text-muted d-block px-2 pt-2 pb-1">
                <i class="bx bx-share-alt me-1"></i>Social Card Preview
              </small>
              @if($page->og_image_url)
                <img src="{{ $page->og_image_url }}"
                     style="width:100%;max-height:130px;object-fit:cover">
              @endif
              <div class="p-2 bg-light" style="font-family:Arial,sans-serif">
                <div class="text-uppercase text-muted" style="font-size:10px">
                  {{ parse_url(url('/'), PHP_URL_HOST) }}
                </div>
                <div style="font-size:14px;font-weight:600;color:#1c1e21">
                  {{ $page->og_title ?: ($page->seo_title ?: $page->title) }}
                </div>
                <div style="font-size:12px;color:#606770;line-height:1.3">
                  {{ Str::limit($page->og_description ?: ($page->seo_description ?: $page->meta_description), 100) }}
                </div>
              </div>
            </div>

          </div>

          {{-- Save --}}
          <div class="px-3 pb-3 pt-2 border-top">
            <button type="submit" class="btn btn-primary w-100 btn-sm">
              <i class="bx bx-save me-1"></i> Save Settings
            </button>
          </div>

        </form>
      </div>
    </div>

    {{-- Add Section --}}
    <div class="card">
      <div class="card-header"><h6 class="mb-0">Add Section</h6></div>
      <div class="card-body">
        <form action="{{ route('pages.sections.add') }}" method="POST">
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
@endsection

@section('page-script')
<script>
document.addEventListener('DOMContentLoaded', function () {

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
        fetch('{{ route("pages.sections.reorder") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ order: order })
        }).catch(function (err) { console.error('Reorder error', err); });
      }
    });
  }

  // ── Settings tabs ─────────────────────────────────────────────────
  document.querySelectorAll('#settingsTabs .nav-link').forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelectorAll('#settingsTabs .nav-link').forEach(function (l) {
        l.classList.remove('active');
      });
      document.querySelectorAll('.tab-panel').forEach(function (p) {
        p.style.display = 'none';
      });
      this.classList.add('active');
      var target = document.getElementById(this.getAttribute('data-tab'));
      if (target) target.style.display = '';
    });
  });

  // ── Image previews ────────────────────────────────────────────────
  function bindImagePreview(inputId, previewId, wrapId) {
    var input = document.getElementById(inputId);
    if (!input) return;
    input.addEventListener('change', function () {
      if (!this.files || !this.files[0]) return;
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
  bindImagePreview('logo-input',     'logo-preview',     'logo-preview-wrap');
  bindImagePreview('favicon-input',  'favicon-preview',  'favicon-preview-wrap');
  bindImagePreview('og-image-input', 'og-preview',       'og-preview-wrap');

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
    seoTitleInput.addEventListener('input', function () {
      serpTitle.textContent = this.value || pageTitle;
    });
  }
  if (seoDescInput && serpDesc) {
    seoDescInput.addEventListener('input', function () {
      serpDesc.textContent = this.value || pageMeta;
    });
  }

});
</script>
@endsection