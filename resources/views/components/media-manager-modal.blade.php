{{-- Media Manager Modal --}}
{{-- Include once in the page. JS is in edit.blade.php page-script section --}}
<div class="modal fade" id="mediaManagerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header py-2 border-bottom">
        <h6 class="modal-title mb-0">
          <i class="bx bx-images me-2 text-primary"></i>Media Manager
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-0" style="min-height:420px">
        <div class="d-flex" style="min-height:420px">

          {{-- Left: Folder tree --}}
          <div class="border-end p-3 flex-shrink-0 d-flex flex-column" style="width:190px;overflow-y:auto">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <small class="fw-semibold text-muted text-uppercase" style="font-size:10px">Carpetas</small>
              <button type="button" class="btn btn-link btn-sm p-0 text-primary"
                      id="mm-new-folder-btn" title="Nueva carpeta">
                <i class="bx bx-folder-plus" style="font-size:1.2rem"></i>
              </button>
            </div>
            <div id="mm-folder-tree" class="small flex-grow-1">
              <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-muted"></div>
              </div>
            </div>
          </div>

          {{-- Right: Files --}}
          <div class="flex-grow-1 p-3 d-flex flex-column" style="min-width:0">

            {{-- Toolbar --}}
            <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
              <nav class="flex-grow-1">
                <ol class="breadcrumb mb-0 small" id="mm-breadcrumb">
                  <li class="breadcrumb-item active">assets</li>
                </ol>
              </nav>
              <label class="btn btn-sm btn-primary mb-0 flex-shrink-0" style="cursor:pointer">
                <i class="bx bx-upload me-1"></i> Subir
                <input type="file" id="mm-upload-input"
                       accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml,
                               application/pdf,application/msword,
                               application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                               text/plain,.csv"
                       multiple class="d-none">
              </label>
              <span id="mm-upload-bar" class="d-none align-items-center gap-1 small text-muted">
                <div class="spinner-border spinner-border-sm text-primary"></div>
                <span id="mm-upload-status"></span>
              </span>
            </div>

            {{-- Loading --}}
            <div id="mm-loading" class="text-center py-5 flex-grow-1 d-flex align-items-center justify-content-center">
              <div class="spinner-border text-primary"></div>
            </div>

            {{-- Empty --}}
            <div id="mm-empty" class="text-center text-muted py-5 flex-grow-1 d-none align-items-center justify-content-center">
              <div>
                <i class="bx bx-folder-open fs-1 d-block mb-2"></i>
                <p class="mb-0">Carpeta vacía.</p>
                <small>Sube archivos o crea una subcarpeta.</small>
              </div>
            </div>

            {{-- Grid --}}
            <div id="mm-grid" class="row g-2 d-none"></div>

          </div>
        </div>
      </div>

      <div class="modal-footer py-2">
        <small class="text-muted me-auto" id="mm-count"></small>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
          Cancelar
        </button>
      </div>

    </div>
  </div>
</div>

{{-- File card template (images only — selected on click) --}}
<template id="mm-card-tpl">
  <div class="col-6 col-sm-4 col-md-3 mm-card" data-name="">
    <div class="border rounded overflow-hidden position-relative mm-card-inner"
         style="cursor:pointer; aspect-ratio:1; background:#f0f0f0;">
      <img src="" alt="" loading="lazy"
           class="w-100 h-100 mm-card-img"
           style="object-fit:cover; transition:opacity .15s">
      <button type="button"
              class="btn btn-danger btn-sm position-absolute mm-delete-btn"
              style="top:4px;right:4px;padding:2px 6px;font-size:11px;opacity:0;transition:opacity .15s"
              title="Eliminar">
        <i class="bx bx-trash"></i>
      </button>
      <div class="position-absolute bottom-0 start-0 end-0 text-center py-1 mm-select-hint"
           style="background:rgba(105,108,255,.85);color:#fff;font-size:11px;opacity:0;transition:opacity .15s">
        Seleccionar
      </div>
    </div>
    <div class="text-truncate small text-muted mt-1 px-1 mm-card-name" style="font-size:10px"></div>
  </div>
</template>

{{-- Folder card template --}}
<template id="mm-folder-card-tpl">
  <div class="col-6 col-sm-4 col-md-3 mm-folder" data-path="" data-name="">
    <div class="border rounded overflow-hidden position-relative mm-folder-inner"
         style="cursor:pointer; aspect-ratio:1; background:#f8f8ff;">
      <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
        <i class="bx bx-folder text-primary" style="font-size:2.5rem"></i>
      </div>
      <button type="button"
              class="btn btn-danger btn-sm position-absolute mm-folder-delete-btn"
              style="top:4px;right:4px;padding:2px 6px;font-size:11px;opacity:0;transition:opacity .15s"
              title="Eliminar carpeta">
        <i class="bx bx-trash"></i>
      </button>
    </div>
    <div class="text-truncate small text-muted mt-1 px-1 mm-folder-name"
         style="font-size:10px;font-weight:500"></div>
  </div>
</template>
