

<?php $__env->startSection('title', 'Página de inicio'); ?>

<?php $__env->startSection('vendor-style'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">

  
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bx bx-layout me-2"></i>Page Sections</h5>
        <a href="<?php echo e(route('welcome')); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
          <i class="bx bx-link-external me-1"></i> Preview
        </a>
      </div>
      <div class="card-body">

        <?php if(session('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div id="sections-list">
          <?php $__empty_1 = true; $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="section-card" data-id="<?php echo e($section->id); ?>">

            <div class="section-header">
              <span class="drag-handle"><i class="bx bx-grid-vertical"></i></span>

              <span class="section-type-badge">
                <i class="bx <?php echo e($types[$section->type]['icon']); ?>"></i>
              </span>

              <div class="flex-grow-1">
                <div class="fw-semibold"><?php echo e($section->title); ?></div>
                <small class="text-muted"><?php echo e($types[$section->type]['label']); ?></small>
              </div>

              <span class="badge <?php echo e($section->is_visible ? 'bg-label-success' : 'bg-label-secondary'); ?> me-1">
                <?php echo e($section->is_visible ? 'Visible' : 'Hidden'); ?>

              </span>

              <button type="button"
                      class="btn btn-sm btn-outline-primary me-1 toggle-section-btn"
                      data-target="body-<?php echo e($section->id); ?>">
                <i class="bx bx-edit"></i> Edit
              </button>

              <form action="<?php echo e(route('pages.sections.toggle', $section)); ?>" method="POST" class="d-inline me-1">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        class="btn btn-sm <?php echo e($section->is_visible ? 'btn-outline-warning' : 'btn-outline-success'); ?>"
                        title="<?php echo e($section->is_visible ? 'Hide section' : 'Show section'); ?>">
                  <i class="bx <?php echo e($section->is_visible ? 'bx-hide' : 'bx-show'); ?>"></i>
                </button>
              </form>

              <form action="<?php echo e(route('pages.sections.delete', $section)); ?>" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this section?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-outline-danger">
                  <i class="bx bx-trash"></i>
                </button>
              </form>
            </div>

            <div class="section-body" id="body-<?php echo e($section->id); ?>">
              <form action="<?php echo e(route('pages.sections.update', $section)); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="row mb-3">
                  <div class="col-md-8">
                    <label class="form-label">Section Title</label>
                    <input type="text" name="title" class="form-control"
                           value="<?php echo e($section->title); ?>" />
                  </div>
                  <div class="col-md-4 d-flex align-items-end pb-1">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox"
                             name="is_visible" value="1"
                             <?php echo e($section->is_visible ? 'checked' : ''); ?>>
                      <label class="form-check-label">Visible</label>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label small fw-semibold">
                    ID / Anchor
                    <span class="text-muted fw-normal">(para menú de navegación)</span>
                  </label>
                  <div class="input-group input-group-sm">
                    <span class="input-group-text text-muted">#</span>
                    <input type="text" name="anchor" class="form-control font-monospace anchor-input"
                           value="<?php echo e($section->anchor); ?>"
                           placeholder="mi-seccion"
                           pattern="[a-z0-9_-]+"
                           title="Solo letras minúsculas, números, guiones y guión bajo">
                  </div>
                  <small class="text-muted">Letras, números, <code>-</code> y <code>_</code>. Usa <code>#mi-seccion</code> como URL en el menú.</small>
                </div>

                <?php echo $__env->make('content.pages.sections.' . $section->type, ['section' => $section], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <div class="mt-3 pt-3 border-top">
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bx bx-save me-1"></i> Save Section
                  </button>
                  <button type="button"
                          class="btn btn-secondary btn-sm ms-1 toggle-section-btn"
                          data-target="body-<?php echo e($section->id); ?>">
                    Cancel
                  </button>
                </div>
              </form>
            </div>

          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="text-center text-muted py-5">
            <i class="bx bx-layout fs-1 d-block mb-2"></i>
            No sections yet. Add one from the panel on the right.
          </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

  
  <div class="col-lg-4">

    
    <div class="card mb-4">
      <div class="card-header">
        <h6 class="mb-0">Page Settings</h6>
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
          <li class="nav-item flex-fill">
            <a class="nav-link small text-center" href="#" data-tab="tab-nav">
              <i class="bx bx-menu me-1"></i>Menú
            </a>
          </li>
        </ul>

        <form action="<?php echo e(route('pages.update')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>

          
          <div class="tab-panel p-3" id="tab-general">
            <div class="mb-3">
              <label class="form-label small">Page Title <span class="text-danger">*</span></label>
              <input type="text" name="title" class="form-control form-control-sm"
                     value="<?php echo e($page->title); ?>" required />
            </div>
            <div class="mb-3">
              <label class="form-label small">Meta Description</label>
              <textarea name="meta_description" class="form-control form-control-sm"
                        rows="2" maxlength="500"><?php echo e($page->meta_description); ?></textarea>
              <small class="text-muted">Used as fallback SEO description.</small>
            </div>
            <div class="mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox"
                       name="is_published" value="1"
                       <?php echo e($page->is_published ? 'checked' : ''); ?>>
                <label class="form-check-label small">Published</label>
              </div>
            </div>

            <hr class="my-2">

            <div class="mb-3">
              <label class="form-label small fw-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#25d366" viewBox="0 0 24 24" class="me-1"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.004 2C6.476 2 2 6.476 2 12.004c0 1.771.463 3.448 1.268 4.91L2 22l5.233-1.249A9.95 9.95 0 0012.004 22C17.528 22 22 17.524 22 12.004 22 6.476 17.528 2 12.004 2zm0 18.199a8.183 8.183 0 01-4.17-1.14l-.299-.178-3.103.741.771-3.016-.196-.31a8.199 8.199 0 113.797 3.903z"/></svg>
                WhatsApp
              </label>
              <div class="input-group input-group-sm">
                <span class="input-group-text">+</span>
                <input type="text" name="whatsapp" class="form-control"
                       value="<?php echo e($page->whatsapp); ?>"
                       placeholder="525512345678"
                       maxlength="20"
                       pattern="[0-9]+"
                       title="Solo números, incluye código de país sin + ni espacios">
              </div>
              <small class="text-muted">Código de país + número, sin + ni espacios. Ej: <code>525512345678</code></small>
            </div>
          </div>

          
          <div class="tab-panel p-3" id="tab-branding" style="display:none">
            <?php echo $__env->make('content.pages._branding_fields', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </div>

          
          <div class="tab-panel p-3" id="tab-seo" style="display:none">

            <div class="mb-3">
              <label class="form-label small fw-semibold">
                SEO Title
                <span class="float-end text-muted" id="seo-title-count">0/70</span>
              </label>
              <input type="text" name="seo_title" id="seo-title-input"
                     class="form-control form-control-sm"
                     value="<?php echo e($page->seo_title); ?>"
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
                        placeholder="Shown in search engine results"><?php echo e($page->seo_description); ?></textarea>
              <small class="text-muted">Recommended: 150–160 characters.</small>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Keywords</label>
              <input type="text" name="seo_keywords"
                     class="form-control form-control-sm"
                     value="<?php echo e($page->seo_keywords); ?>"
                     placeholder="laravel, admin, dashboard">
              <small class="text-muted">Comma-separated. Minor ranking factor today.</small>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Canonical URL</label>
              <input type="url" name="canonical_url"
                     class="form-control form-control-sm"
                     value="<?php echo e($page->canonical_url); ?>"
                     placeholder="https://yourdomain.com/">
              <small class="text-muted">Prevents duplicate content issues.</small>
            </div>

            
            <?php
              $serpTitleText = $page->seo_title ?: $page->title;
              $serpDescText  = $page->seo_description ?: $page->meta_description;
              $serpUrl       = $page->canonical_url ?: url('/');
            ?>
            <div class="border rounded p-2 bg-light mt-2">
              <small class="text-muted d-block mb-2">
                <i class="bx bx-search me-1"></i>Search Result Preview
              </small>
              <div style="font-family:Arial,sans-serif">
                <div id="serp-title"
                     style="color:#1a0dab;font-size:18px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                  <?php echo e($serpTitleText); ?>

                </div>
                <div style="color:#006621;font-size:13px">
                  <?php echo e($serpUrl); ?>

                </div>
                <div id="serp-desc" style="color:#545454;font-size:13px;line-height:1.4;overflow:hidden">
                  <?php echo e($serpDescText); ?>

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
						<?php echo e($page->schema_markup ? json_encode($page->schema_markup, JSON_PRETTY_PRINT) : ''); ?></textarea>
              <small class="text-muted">Optional structured data for rich search results.</small>
            </div>
          </div>

          
          <div class="tab-panel p-3" id="tab-social" style="display:none">

            <p class="small text-muted mb-3">
              Controls how your page appears when shared on social platforms.
            </p>

            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Title</label>
              <input type="text" name="og_title"
                     class="form-control form-control-sm"
                     value="<?php echo e($page->og_title); ?>"
                     maxlength="95"
                     placeholder="Leave blank to use SEO title">
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Description</label>
              <textarea name="og_description"
                        class="form-control form-control-sm" rows="2"
                        maxlength="200"
                        placeholder="Leave blank to use SEO description"><?php echo e($page->og_description); ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-semibold">OG Image</label>
              <?php if($page->og_image_url): ?>
                <div class="mb-2">
                  <img src="<?php echo e($page->og_image_url); ?>" alt="OG Image"
                       class="img-fluid rounded" style="max-height:80px">
                </div>
              <?php endif; ?>
              <div id="og-preview-wrap" style="display:none" class="mb-1">
                <img id="og-preview" src=""
                     class="img-fluid rounded" style="max-height:80px">
              </div>
              <input type="hidden" name="og_image_media" id="og-media-url" value="">
              <div class="d-flex gap-2 align-items-center">
                <input type="file" name="og_image" id="og-image-input"
                       class="form-control form-control-sm"
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
              <small class="text-muted">1200×630px recomendado — o escoge del media manager.</small>
            </div>

            <hr>

            <div class="mb-3">
              <label class="form-label small fw-semibold">Twitter Card Type</label>
              <select name="twitter_card" class="form-select form-select-sm">
                <option value="summary"
                  <?php echo e(($page->twitter_card ?? '') === 'summary' ? 'selected' : ''); ?>>
                  Summary (small image)
                </option>
                <option value="summary_large_image"
                  <?php echo e(($page->twitter_card ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : ''); ?>>
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
                       value="<?php echo e(ltrim($page->twitter_site ?? '', '@')); ?>"
                       placeholder="yourusername">
              </div>
            </div>

            <div class="border rounded overflow-hidden mt-3">
              <small class="text-muted d-block px-2 pt-2 pb-1">
                <i class="bx bx-share-alt me-1"></i>Social Card Preview
              </small>
              <?php if($page->og_image_url): ?>
                <img src="<?php echo e($page->og_image_url); ?>"
                     style="width:100%;max-height:130px;object-fit:cover">
              <?php endif; ?>
              <div class="p-2 bg-light" style="font-family:Arial,sans-serif">
                <div class="text-uppercase text-muted" style="font-size:10px">
                  <?php echo e(parse_url(url('/'), PHP_URL_HOST)); ?>

                </div>
                <div style="font-size:14px;font-weight:600;color:#1c1e21">
                  <?php echo e($page->og_title ?: ($page->seo_title ?: $page->title)); ?>

                </div>
                <div style="font-size:12px;color:#606770;line-height:1.3">
                  <?php echo e(Str::limit($page->og_description ?: ($page->seo_description ?: $page->meta_description), 100)); ?>

                </div>
              </div>
            </div>

          </div>

          
          <div class="tab-panel p-3" id="tab-nav" style="display:none">

            
            <div class="mb-3">
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="nav-enabled-check"
                       name="nav_enabled" value="1"
                       <?php echo e($page->nav_enabled ? 'checked' : ''); ?>>
                <label class="form-check-label small fw-semibold" for="nav-enabled-check">
                  Mostrar menú de navegación
                </label>
              </div>
              <label class="form-label small fw-semibold mt-1">Posición del menú</label>
              <div class="d-flex gap-2 flex-wrap">
                <?php $__currentLoopData = ['normal' => ['bx-menu','Normal'],'sticky' => ['bx-pin','Sticky'],'fixed' => ['bx-dock-top','Fixed']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos => [$icon, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="border rounded px-2 py-1 d-flex align-items-center gap-1 cursor-pointer small
                              <?php echo e(($page->nav_position ?? 'normal') === $pos ? 'border-primary text-primary bg-label-primary' : ''); ?>"
                       style="cursor:pointer" id="nav-pos-label-<?php echo e($pos); ?>">
                  <input type="radio" name="nav_position" value="<?php echo e($pos); ?>" class="d-none nav-pos-radio"
                         <?php echo e(($page->nav_position ?? 'normal') === $pos ? 'checked' : ''); ?>>
                  <i class="bx <?php echo e($icon); ?>"></i> <?php echo e($label); ?>

                </label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
              <small class="text-muted d-block mt-1">
                <strong>Normal:</strong> fluye con la página.
                <strong>Sticky:</strong> queda arriba al hacer scroll.
                <strong>Fixed:</strong> siempre visible encima del contenido.
              </small>
            </div>

            <hr class="my-3">

            
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="small fw-semibold">Páginas del menú</span>
              <button type="button" class="btn btn-sm btn-outline-primary" id="nav-add-item-btn">
                <i class="bx bx-plus me-1"></i>Agregar página
              </button>
            </div>

            <div id="nav-items-list" class="mb-2">
              
            </div>

            
            <input type="hidden" name="nav_items_json" id="nav-items-json">

            <small class="text-muted">Arrastra para reordenar. Cada página puede tener sub-páginas.</small>
          </div>

          
          <div class="px-3 pb-3 pt-2 border-top">
            <button type="submit" class="btn btn-primary w-100 btn-sm">
              <i class="bx bx-save me-1"></i> Save Settings
            </button>
          </div>

        </form>
      </div>
    </div>

    
    <div class="card">
      <div class="card-header"><h6 class="mb-0">Add Section</h6></div>
      <div class="card-body">
        <form action="<?php echo e(route('pages.sections.add')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <div class="row g-2">
            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $typeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-6">
              <button type="submit" name="type" value="<?php echo e($typeKey); ?>"
                      class="btn btn-outline-secondary w-100 d-flex flex-column align-items-center py-3 gap-1">
                <i class="bx <?php echo e($typeData['icon']); ?> fs-3"></i>
                <small><?php echo e($typeData['label']); ?></small>
              </button>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
<?php echo $__env->make('components.media-manager-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
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
        fetch('<?php echo e(route("pages.sections.reorder")); ?>', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
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
  function bindImagePreview(inputId, previewId, wrapId, clearFieldId) {
    var input = document.getElementById(inputId);
    if (!input) return;
    input.addEventListener('change', function () {
      if (!this.files || !this.files[0]) return;
      // File chosen — clear any media-manager URL so the file wins
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
  bindImagePreview('logo-input',     'logo-preview',     'logo-preview-wrap',    'logo-media-url');
  bindImagePreview('favicon-input',  'favicon-preview',  'favicon-preview-wrap', 'favicon-media-url');
  bindImagePreview('og-image-input', 'og-preview',       'og-preview-wrap',      'og-media-url');

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

  // ── Anchor slug auto-clean ────────────────────────────────────────
  document.querySelectorAll('.anchor-input').forEach(function (input) {
    input.addEventListener('input', function () {
      var pos = this.selectionStart;
      this.value = this.value.toLowerCase().replace(/[^a-z0-9_-]/g, '');
      this.setSelectionRange(pos, pos);
    });
  });

  // ── Nav position radio highlight ────────────────────────────────
  document.querySelectorAll('.nav-pos-radio').forEach(function (radio) {
    radio.addEventListener('change', function () {
      document.querySelectorAll('[id^="nav-pos-label-"]').forEach(function (lbl) {
        lbl.classList.remove('border-primary', 'text-primary', 'bg-label-primary');
      });
      var lbl = document.getElementById('nav-pos-label-' + this.value);
      if (lbl) lbl.classList.add('border-primary', 'text-primary', 'bg-label-primary');
    });
  });

  // ── Nav menu builder ──────────────────────────────────────────────
  var navItems = <?php echo json_encode($page->nav_items ?? [], 15, 512) ?>;
  var navList  = document.getElementById('nav-items-list');
  var navJson  = document.getElementById('nav-items-json');

  function renderNavItems() {
    navList.innerHTML = '';
    navItems.forEach(function (item, idx) {
      navList.appendChild(buildNavItemEl(item, idx));
    });
    syncNavJson();
    initNavSortable();
  }

  function syncNavJson() {
    navJson.value = JSON.stringify(navItems);
  }

  function buildNavItemEl(item, idx) {
    var wrap = document.createElement('div');
    wrap.className = 'border rounded mb-2 nav-item-wrap';
    wrap.dataset.idx = idx;

    var header = document.createElement('div');
    header.className = 'd-flex align-items-center gap-1 p-2';
    header.innerHTML =
      '<span class="nav-drag-handle me-1" style="cursor:grab;color:#aaa"><i class="bx bx-grid-vertical"></i></span>' +
      '<input type="text" class="form-control form-control-sm me-1 nav-item-label" placeholder="Etiqueta" value="' + escHtml(item.label || '') + '">' +
      '<input type="text" class="form-control form-control-sm me-1 nav-item-url" placeholder="URL" value="' + escHtml(item.url || '') + '">' +
      '<button type="button" class="btn btn-sm btn-outline-secondary me-1 nav-sub-toggle-btn" title="Sub-páginas"><i class="bx bx-chevron-down"></i></button>' +
      '<button type="button" class="btn btn-sm btn-outline-danger nav-remove-btn" title="Eliminar"><i class="bx bx-trash"></i></button>';

    var label = header.querySelector('.nav-item-label');
    var url   = header.querySelector('.nav-item-url');
    label.addEventListener('input', function () { item.label = this.value; syncNavJson(); });
    url.addEventListener('input',   function () { item.url   = this.value; syncNavJson(); });

    header.querySelector('.nav-remove-btn').addEventListener('click', function () {
      navItems.splice(idx, 1);
      renderNavItems();
    });

    var subWrap = document.createElement('div');
    subWrap.className = 'px-3 pb-2 pt-1 border-top bg-light';
    subWrap.style.display = (item.children && item.children.length) ? '' : 'none';

    var subList = document.createElement('div');
    subList.className = 'nav-sub-list mb-2';

    (item.children || []).forEach(function (child, cidx) {
      subList.appendChild(buildSubItemEl(item, child, cidx));
    });

    var addSubBtn = document.createElement('button');
    addSubBtn.type = 'button';
    addSubBtn.className = 'btn btn-xs btn-outline-secondary btn-sm';
    addSubBtn.innerHTML = '<i class="bx bx-plus me-1"></i>Sub-página';
    addSubBtn.addEventListener('click', function () {
      if (!item.children) item.children = [];
      item.children.push({ label: '', url: '' });
      renderNavItems();
      // re-open sub panel for this item
      var newWrap = navList.querySelector('[data-idx="' + idx + '"]');
      if (newWrap) newWrap.querySelector('.nav-sub-list').parentElement.style.display = '';
    });

    subWrap.appendChild(subList);
    subWrap.appendChild(addSubBtn);

    header.querySelector('.nav-sub-toggle-btn').addEventListener('click', function () {
      subWrap.style.display = subWrap.style.display === 'none' ? '' : 'none';
    });

    wrap.appendChild(header);
    wrap.appendChild(subWrap);
    return wrap;
  }

  function buildSubItemEl(parentItem, child, cidx) {
    var row = document.createElement('div');
    row.className = 'd-flex align-items-center gap-1 mb-1';
    row.innerHTML =
      '<span style="color:#aaa;width:16px;flex-shrink:0"><i class="bx bx-subdirectory-right"></i></span>' +
      '<input type="text" class="form-control form-control-sm me-1" placeholder="Etiqueta" value="' + escHtml(child.label || '') + '">' +
      '<input type="text" class="form-control form-control-sm me-1" placeholder="URL" value="' + escHtml(child.url || '') + '">' +
      '<button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bx bx-trash"></i></button>';

    row.querySelectorAll('input')[0].addEventListener('input', function () { child.label = this.value; syncNavJson(); });
    row.querySelectorAll('input')[1].addEventListener('input', function () { child.url   = this.value; syncNavJson(); });
    row.querySelector('button').addEventListener('click', function () {
      parentItem.children.splice(cidx, 1);
      renderNavItems();
    });
    return row;
  }

  document.getElementById('nav-add-item-btn').addEventListener('click', function () {
    navItems.push({ label: '', url: '', children: [] });
    renderNavItems();
  });

  function initNavSortable() {
    if (typeof Sortable === 'undefined') return;
    Sortable.create(navList, {
      handle: '.nav-drag-handle',
      animation: 150,
      onEnd: function (e) {
        var moved = navItems.splice(e.oldIndex, 1)[0];
        navItems.splice(e.newIndex, 0, moved);
        // Re-index without full re-render to avoid losing focus
        navList.querySelectorAll('.nav-item-wrap').forEach(function (el, i) {
          el.dataset.idx = i;
        });
        syncNavJson();
      }
    });
  }

  function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  renderNavItems();

  // ── Live SERP preview ─────────────────────────────────────────────
  var serpTitle     = document.getElementById('serp-title');
  var serpDesc      = document.getElementById('serp-desc');
  var seoTitleInput = document.getElementById('seo-title-input');
  var seoDescInput  = document.getElementById('seo-desc-input');
  var pageTitle     = <?php echo json_encode($page->title, 15, 512) ?>;
  var pageMeta      = <?php echo json_encode($page->meta_description ?? '', 15, 512) ?>;

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


<script>
(function () {
  var mediaIndexUrl   = '<?php echo e(route("media.index")); ?>';
  var mediaDeleteUrl  = '<?php echo e(route("media.destroy")); ?>';
  var mediaUploadUrl  = '<?php echo e(route("media.upload")); ?>';
  var mediaTreeUrl    = '<?php echo e(route("media.tree")); ?>';
  var folderCreateUrl = '<?php echo e(route("media.folders.create")); ?>';
  var folderDeleteUrl = '<?php echo e(route("media.folders.delete")); ?>';
  var csrfToken       = '<?php echo e(csrf_token()); ?>';

  var mmModal     = null;
  var mmTarget    = { fieldId: null, previewId: null, wrapId: null };
  var currentPath = '';

  // ── Open modal ────────────────────────────────────────────────────
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.media-browse-btn');
    if (!btn) return;

    mmTarget.fieldId   = btn.dataset.field;
    mmTarget.previewId = btn.dataset.preview;
    mmTarget.wrapId    = btn.dataset.previewWrap;

    if (!mmModal) {
      mmModal = new bootstrap.Modal(document.getElementById('mediaManagerModal'));
    }
    currentPath = '';
    mmModal.show();
    loadFolderTree();
    loadMedia('');
  });

  // ── Folder tree ───────────────────────────────────────────────────
  function loadFolderTree() {
    fetch(mediaTreeUrl, { headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } })
      .then(function (r) { return r.json(); })
      .then(function (tree) {
        var el = document.getElementById('mm-folder-tree');
        el.innerHTML = '';

        var root = document.createElement('a');
        root.href = '#';
        root.className = 'd-block px-2 py-1 rounded text-decoration-none fw-semibold mm-tree-node';
        root.style.cssText = 'color:#4a4e69;font-size:12px';
        root.dataset.path = '';
        root.innerHTML = '<i class="bx bx-hard-drive me-1"></i>assets';
        root.addEventListener('click', function (e) { e.preventDefault(); navigateTo(''); });
        el.appendChild(root);

        if (tree.children && tree.children.length) {
          el.appendChild(buildTreeEl(tree.children, 1));
        }
        updateTreeActive();
      })
      .catch(function () {
        var el = document.getElementById('mm-folder-tree');
        el.innerHTML = '<small class="text-muted px-2">Error cargando</small>';
      });
  }

  function buildTreeEl(items, depth) {
    var ul = document.createElement('ul');
    ul.className = 'list-unstyled mb-0';
    ul.style.paddingLeft = (depth * 12) + 'px';
    items.forEach(function (item) {
      var li = document.createElement('li');
      var a  = document.createElement('a');
      a.href = '#';
      a.className = 'd-block px-2 py-1 rounded text-decoration-none mm-tree-node';
      a.style.cssText = 'color:#4a4e69;font-size:12px';
      a.dataset.path = item.path;
      a.innerHTML = '<i class="bx bx-folder me-1 text-muted" style="font-size:12px"></i>' + escHtml(item.name);
      a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(item.path); });
      li.appendChild(a);
      if (item.children && item.children.length) {
        li.appendChild(buildTreeEl(item.children, depth + 1));
      }
      ul.appendChild(li);
    });
    return ul;
  }

  function updateTreeActive() {
    document.querySelectorAll('.mm-tree-node').forEach(function (a) {
      var active = a.dataset.path === currentPath;
      a.style.background = active ? '#696cff' : '';
      a.style.color      = active ? '#fff'     : '#4a4e69';
    });
  }

  function navigateTo(path) {
    currentPath = path;
    updateTreeActive();
    updateBreadcrumb(path);
    loadMedia(path);
  }

  // ── Breadcrumb ────────────────────────────────────────────────────
  function updateBreadcrumb(path) {
    var bc = document.getElementById('mm-breadcrumb');
    bc.innerHTML = '';

    var rootLi = document.createElement('li');
    rootLi.className = 'breadcrumb-item' + (path === '' ? ' active' : '');
    if (path === '') {
      rootLi.textContent = 'assets';
    } else {
      var a = document.createElement('a');
      a.href = '#'; a.textContent = 'assets';
      a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(''); });
      rootLi.appendChild(a);
    }
    bc.appendChild(rootLi);

    if (path !== '') {
      var parts = path.split('/');
      var built = '';
      parts.forEach(function (part, idx) {
        built = built ? built + '/' + part : part;
        var li = document.createElement('li');
        li.className = 'breadcrumb-item' + (idx === parts.length - 1 ? ' active' : '');
        if (idx === parts.length - 1) {
          li.textContent = part;
        } else {
          var a = document.createElement('a');
          a.href = '#'; a.textContent = part;
          var navPath = built;
          a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(navPath); });
          li.appendChild(a);
        }
        bc.appendChild(li);
      });
    }
  }

  // ── Load files ────────────────────────────────────────────────────
  function loadMedia(path) {
    if (path !== undefined) currentPath = path;

    var loading = document.getElementById('mm-loading');
    var grid    = document.getElementById('mm-grid');
    var empty   = document.getElementById('mm-empty');

    loading.style.display = '';
    loading.className = 'text-center py-5 flex-grow-1 d-flex align-items-center justify-content-center';
    grid.classList.add('d-none');
    empty.classList.add('d-none');
    empty.classList.remove('d-flex');
    grid.innerHTML = '';

    updateBreadcrumb(currentPath);

    fetch(mediaIndexUrl + '?include_dirs=1&type=all&path=' + encodeURIComponent(currentPath), {
      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
      .then(function (r) { return r.json(); })
      .then(renderGrid)
      .catch(function () {
        loading.style.display = 'none';
        empty.classList.remove('d-none');
        empty.classList.add('d-flex');
      });
  }

  // ── Render grid ───────────────────────────────────────────────────
  function renderGrid(items) {
    var loading = document.getElementById('mm-loading');
    var grid    = document.getElementById('mm-grid');
    var empty   = document.getElementById('mm-empty');
    var count   = document.getElementById('mm-count');

    loading.style.display = 'none';
    grid.innerHTML = '';

    if (!items || items.length === 0) {
      empty.classList.remove('d-none');
      empty.classList.add('d-flex');
      count.textContent = '';
      return;
    }

    empty.classList.add('d-none');
    empty.classList.remove('d-flex');
    grid.classList.remove('d-none');

    var imgCount = items.filter(function (i) { return i.type === 'image'; }).length;
    count.textContent = imgCount + ' imagen' + (imgCount !== 1 ? 'es' : '');

    var fileTpl   = document.getElementById('mm-card-tpl');
    var folderTpl = document.getElementById('mm-folder-card-tpl');

    items.forEach(function (item) {
      if (item.type === 'folder') {
        var clone = folderTpl.content.cloneNode(true);
        var card  = clone.querySelector('.mm-folder');
        card.dataset.path = item.path;
        card.dataset.name = item.name;
        clone.querySelector('.mm-folder-name').textContent = item.name;

        // Navigate into folder
        clone.querySelector('.mm-folder-inner').addEventListener('click', function (e) {
          if (e.target.closest('.mm-folder-delete-btn')) return;
          navigateTo(item.path);
          loadFolderTree();
        });

        // Delete folder
        clone.querySelector('.mm-folder-delete-btn').addEventListener('click', function (e) {
          e.stopPropagation();
          if (!confirm('¿Eliminar carpeta "' + item.name + '" y todo su contenido?')) return;
          fetch(folderDeleteUrl, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ path: item.path })
          })
            .then(function (r) { return r.json(); })
            .then(function (d) {
              if (d.success) { loadFolderTree(); loadMedia(currentPath); }
            });
        });

        // Hover
        var inner = clone.querySelector('.mm-folder-inner');
        inner.addEventListener('mouseenter', function () {
          inner.querySelector('.mm-folder-delete-btn').style.opacity = '1';
        });
        inner.addEventListener('mouseleave', function () {
          inner.querySelector('.mm-folder-delete-btn').style.opacity = '0';
        });

        grid.appendChild(clone);

      } else if (item.type === 'image') {
        var clone = fileTpl.content.cloneNode(true);
        var card  = clone.querySelector('.mm-card');
        card.dataset.name = item.name;
        clone.querySelector('.mm-card-img').src = item.url;
        clone.querySelector('.mm-card-name').textContent = item.name;

        var inner = clone.querySelector('.mm-card-inner');
        inner.addEventListener('mouseenter', function () {
          inner.querySelector('.mm-delete-btn').style.opacity  = '1';
          inner.querySelector('.mm-select-hint').style.opacity = '1';
        });
        inner.addEventListener('mouseleave', function () {
          inner.querySelector('.mm-delete-btn').style.opacity  = '0';
          inner.querySelector('.mm-select-hint').style.opacity = '0';
        });

        // Select
        inner.addEventListener('click', function (e) {
          if (e.target.closest('.mm-delete-btn')) return;
          selectImage(item.url);
        });

        // Delete
        clone.querySelector('.mm-delete-btn').addEventListener('click', function (e) {
          e.stopPropagation();
          if (!confirm('¿Eliminar "' + item.name + '"?')) return;
          fetch(mediaDeleteUrl, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name: item.name, path: currentPath })
          })
            .then(function (r) { return r.json(); })
            .then(function (d) { if (d.success) loadMedia(currentPath); });
        });

        grid.appendChild(clone);
      }
    });
  }

  // ── Select image → fill target ─────────────────────────────────────
  function selectImage(url) {
    var field = document.getElementById(mmTarget.fieldId);
    if (field) field.value = url;

    var preview = document.getElementById(mmTarget.previewId);
    if (preview) { preview.src = url; preview.style.display = ''; }

    var wrap = document.getElementById(mmTarget.wrapId);
    if (wrap) wrap.style.display = '';

    if (mmModal) mmModal.hide();
  }

  // ── Upload from modal ─────────────────────────────────────────────
  document.getElementById('mm-upload-input').addEventListener('change', function () {
    var files = Array.from(this.files);
    if (!files.length) return;

    var bar    = document.getElementById('mm-upload-bar');
    var status = document.getElementById('mm-upload-status');
    bar.classList.remove('d-none');
    bar.classList.add('d-flex');
    var input    = this;
    var uploaded = 0;
    var total    = files.length;

    files.forEach(function (file) {
      status.textContent = 'Subiendo ' + uploaded + '/' + total + '…';
      var fd = new FormData();
      fd.append('file', file);
      fd.append('_token', csrfToken);
      fd.append('path', currentPath);
      fetch(mediaUploadUrl, { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function () {
          uploaded++;
          if (uploaded === total) {
            bar.classList.add('d-none');
            bar.classList.remove('d-flex');
            input.value = '';
            loadMedia(currentPath);
          } else {
            status.textContent = 'Subiendo ' + uploaded + '/' + total + '…';
          }
        })
        .catch(function () {
          uploaded++;
          if (uploaded === total) { bar.classList.add('d-none'); bar.classList.remove('d-flex'); }
        });
    });
  });

  // ── New folder from modal ─────────────────────────────────────────
  document.getElementById('mm-new-folder-btn').addEventListener('click', function () {
    var name = prompt('Nombre de la nueva carpeta:');
    if (!name || !name.trim()) return;
    fetch(folderCreateUrl, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ name: name.trim(), path: currentPath })
    })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (d.success) { loadFolderTree(); loadMedia(currentPath); }
        else { alert(d.message || 'Error creando carpeta'); }
      });
  });

  function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

}());
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentNavbarLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/pages/edit.blade.php ENDPATH**/ ?>