@extends('layouts/contentNavbarLayout')

@section('title', 'Media Manager')

@section('vendor-style')
<style>
/* ── Drop zone ───────────────────────────────────── */
#mm-drop-zone {
  border: 2px dashed #d9dee3;
  border-radius: 10px;
  transition: border-color .2s, background .2s;
  cursor: pointer;
}
#mm-drop-zone.drag-over {
  border-color: #696cff;
  background: rgba(105,108,255,.05);
}

/* ── File cards ──────────────────────────────────── */
.mm-file-card {
  border: 1px solid #d9dee3;
  border-radius: 8px;
  overflow: hidden;
  transition: box-shadow .15s, border-color .15s;
  background: #fff;
  position: relative;
}
.mm-file-card:hover {
  box-shadow: 0 4px 16px rgba(105,108,255,.18);
  border-color: #696cff;
}
.mm-thumb {
  width: 100%;
  aspect-ratio: 1;
  object-fit: cover;
  background: #f0f0f8;
  display: block;
}
.mm-doc-icon {
  width: 100%;
  aspect-ratio: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f8f8ff;
  font-size: 2.5rem;
}
.mm-folder-card {
  border: 1px solid #d9dee3;
  border-radius: 8px;
  overflow: hidden;
  transition: box-shadow .15s, border-color .15s;
  background: #f8f8ff;
  cursor: pointer;
  position: relative;
}
.mm-folder-card:hover {
  box-shadow: 0 4px 16px rgba(105,108,255,.18);
  border-color: #696cff;
}
.mm-folder-thumb {
  width: 100%;
  aspect-ratio: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
}
.mm-file-name {
  font-size: 12px;
  font-weight: 500;
  word-break: break-all;
  padding: 2px 4px;
}
.mm-file-size { font-size: 11px; color: #a1acb8; }
.mm-actions { gap: 4px; }
.mm-actions .btn { padding: 3px 7px; font-size: 11px; }
.mm-del-overlay {
  position: absolute;
  top: 4px;
  right: 4px;
  opacity: 0;
  transition: opacity .15s;
}
.mm-folder-card:hover .mm-del-overlay,
.mm-file-card:hover .mm-del-overlay {
  opacity: 1;
}

/* ── Folder tree ─────────────────────────────────── */
.mm-tree-item {
  display: block;
  padding: 4px 8px;
  border-radius: 6px;
  text-decoration: none;
  color: #4a4e69;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.mm-tree-item:hover { background: #f0f0ff; color: #696cff; }
.mm-tree-item.active { background: #696cff; color: #fff; }

/* ── Filter tabs ─────────────────────────────────── */
.mm-filter-btn.active {
  background: #696cff;
  color: #fff;
  border-color: #696cff;
}

/* ── Upload progress bar ─────────────────────────── */
#mm-progress-wrap { display: flex; align-items: center; gap: 8px; }

/* ── Empty / loading states ──────────────────────── */
#mm-empty, #mm-loading { min-height: 260px; }
</style>
@endsection

@section('content')
<div class="row g-4">

  {{-- ── Sidebar: Folder tree ──────────────────────────────────── --}}
  <div class="col-md-3 col-lg-2">
    <div class="card h-100">
      <div class="card-header py-2 d-flex align-items-center justify-content-between">
        <small class="fw-semibold text-uppercase text-muted" style="font-size:10px">
          <i class="bx bx-folder me-1"></i>Carpetas
        </small>
        <button type="button" class="btn btn-sm btn-outline-primary p-0 px-1"
                id="mm-new-folder-btn" title="Nueva carpeta" style="font-size:13px">
          <i class="bx bx-folder-plus"></i>
        </button>
      </div>
      <div class="card-body p-2" style="overflow-y:auto; max-height:600px">
        <div id="mm-folder-tree" class="small">
          <div class="text-center py-3">
            <div class="spinner-border spinner-border-sm text-muted"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Main area ───────────────────────────────────────────────── --}}
  <div class="col-md-9 col-lg-10">
    <div class="card">

      {{-- Header --}}
      <div class="card-header d-flex flex-wrap align-items-center gap-3">
        <div class="flex-grow-1">
          <nav>
            <ol class="breadcrumb mb-0" id="mm-breadcrumb">
              <li class="breadcrumb-item active">assets</li>
            </ol>
          </nav>
          <small class="text-muted" id="mm-stats"></small>
        </div>

        <div class="d-flex align-items-center gap-2">
          {{-- Progress --}}
          <div id="mm-progress-wrap" class="d-none">
            <div class="spinner-border spinner-border-sm text-primary"></div>
            <span id="mm-progress-label" class="small text-muted"></span>
          </div>
          {{-- Upload button --}}
          <label class="btn btn-primary btn-sm mb-0" style="cursor:pointer">
            <i class="bx bx-upload me-1"></i> Subir archivos
            <input type="file" id="mm-file-input"
                   accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml,
                           application/pdf,application/msword,
                           application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                           application/vnd.ms-excel,
                           application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                           text/plain,.csv,.zip"
                   multiple class="d-none">
          </label>
        </div>
      </div>

      <div class="card-body">

        {{-- Drop zone --}}
        <div id="mm-drop-zone" class="p-4 text-center mb-4">
          <i class="bx bx-cloud-upload fs-1 text-muted d-block mb-1"></i>
          <p class="mb-0 text-muted small">
            Arrastra archivos aquí o haz clic en <strong>Subir archivos</strong>
          </p>
          <small class="text-muted">
            Imágenes (JPG, PNG, WebP, GIF, SVG) y documentos (PDF, Word, Excel, TXT, CSV, ZIP) — máx. 10 MB
          </small>
        </div>

        {{-- Filters + Search --}}
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
          <div class="btn-group btn-group-sm" role="group">
            <button type="button" class="btn btn-outline-secondary mm-filter-btn active" data-filter="all">
              <i class="bx bx-grid me-1"></i> Todos
            </button>
            <button type="button" class="btn btn-outline-secondary mm-filter-btn" data-filter="images">
              <i class="bx bx-image me-1"></i> Imágenes
            </button>
            <button type="button" class="btn btn-outline-secondary mm-filter-btn" data-filter="documents">
              <i class="bx bx-file me-1"></i> Documentos
            </button>
          </div>

          <div class="ms-auto" style="min-width:220px">
            <div class="input-group input-group-sm">
              <span class="input-group-text"><i class="bx bx-search"></i></span>
              <input type="text" id="mm-search" class="form-control" placeholder="Buscar por nombre…">
            </div>
          </div>
        </div>

        {{-- Loading --}}
        <div id="mm-loading" class="d-flex align-items-center justify-content-center">
          <div class="text-center">
            <div class="spinner-border text-primary mb-2"></div>
            <p class="text-muted small mb-0">Cargando archivos…</p>
          </div>
        </div>

        {{-- Empty --}}
        <div id="mm-empty" class="d-none align-items-center justify-content-center">
          <div class="text-center text-muted">
            <i class="bx bx-folder-open fs-1 d-block mb-2"></i>
            <p class="mb-0">Carpeta vacía.</p>
            <small>Sube tu primer archivo o crea una subcarpeta.</small>
          </div>
        </div>

        {{-- File + Folder grid --}}
        <div id="mm-grid" class="row g-3 d-none"></div>

      </div>
    </div>
  </div>
</div>

{{-- Rename modal --}}
<div class="modal fade" id="renameModal" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title">Renombrar archivo</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label class="form-label small">Nuevo nombre <small class="text-muted">(sin extensión)</small></label>
        <input type="text" id="rename-input" class="form-control form-control-sm" placeholder="nuevo-nombre">
        <small id="rename-ext" class="text-muted mt-1 d-block"></small>
      </div>
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-sm btn-primary" id="rename-confirm-btn">
          <i class="bx bx-check me-1"></i> Renombrar
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
(function () {
  var apiUrl         = '{{ route("media.index") }}';
  var uploadUrl      = '{{ route("media.upload") }}';
  var renameUrl      = '{{ route("media.rename") }}';
  var deleteUrl      = '{{ route("media.destroy") }}';
  var treeUrl        = '{{ route("media.tree") }}';
  var folderCreateUrl= '{{ route("media.folders.create") }}';
  var folderDeleteUrl= '{{ route("media.folders.delete") }}';
  var csrf           = '{{ csrf_token() }}';

  // ── State ─────────────────────────────────────────────────────────
  var allItems     = [];
  var currentPath  = '';
  var activeFilter = 'all';
  var renameTarget = null;
  var renameModal  = null;

  // ── Elements ──────────────────────────────────────────────────────
  var grid        = document.getElementById('mm-grid');
  var loading     = document.getElementById('mm-loading');
  var empty       = document.getElementById('mm-empty');
  var statsEl     = document.getElementById('mm-stats');
  var searchInput = document.getElementById('mm-search');

  // ── Folder tree ───────────────────────────────────────────────────
  function loadFolderTree() {
    fetch(treeUrl, { headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } })
      .then(function (r) { return r.json(); })
      .then(function (tree) {
        var el = document.getElementById('mm-folder-tree');
        el.innerHTML = '';

        var root = document.createElement('a');
        root.href = '#';
        root.className = 'mm-tree-item d-block mb-1 fw-semibold';
        root.dataset.path = '';
        root.innerHTML = '<i class="bx bx-hard-drive me-1"></i>assets';
        root.addEventListener('click', function (e) { e.preventDefault(); navigateTo(''); });
        el.appendChild(root);

        if (tree.children && tree.children.length) {
          el.appendChild(buildTreeEl(tree.children, 1));
        }
        updateTreeActive();
      });
  }

  function buildTreeEl(items, depth) {
    var ul = document.createElement('ul');
    ul.className = 'list-unstyled mb-0';
    ul.style.paddingLeft = (depth * 14) + 'px';
    items.forEach(function (item) {
      var li  = document.createElement('li');
      var a   = document.createElement('a');
      a.href = '#';
      a.className = 'mm-tree-item d-block';
      a.dataset.path = item.path;
      a.innerHTML = '<i class="bx bx-folder me-1"></i>' + escHtml(item.name);
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
    document.querySelectorAll('.mm-tree-item').forEach(function (a) {
      var isActive = a.dataset.path === currentPath;
      a.classList.toggle('active', isActive);
    });
  }

  function navigateTo(path) {
    currentPath  = path;
    activeFilter = 'all';
    document.querySelectorAll('.mm-filter-btn').forEach(function (b) {
      b.classList.toggle('active', b.dataset.filter === 'all');
    });
    updateTreeActive();
    updateBreadcrumb(path);
    loadFiles();
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
      a.href = '#';
      a.textContent = 'assets';
      a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(''); });
      rootLi.appendChild(a);
    }
    bc.appendChild(rootLi);

    if (path !== '') {
      var parts  = path.split('/');
      var built  = '';
      parts.forEach(function (part, idx) {
        built = built ? built + '/' + part : part;
        var li = document.createElement('li');
        li.className = 'breadcrumb-item' + (idx === parts.length - 1 ? ' active' : '');
        if (idx === parts.length - 1) {
          li.textContent = part;
        } else {
          var a = document.createElement('a');
          a.href = '#';
          a.textContent = part;
          var navPath = built;
          a.addEventListener('click', function (e) { e.preventDefault(); navigateTo(navPath); });
          li.appendChild(a);
        }
        bc.appendChild(li);
      });
    }
  }

  // ── Load files ────────────────────────────────────────────────────
  function loadFiles() {
    showState('loading');
    var url = apiUrl + '?include_dirs=1&type=' + activeFilter + '&path=' + encodeURIComponent(currentPath);
    fetch(url, { headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } })
      .then(function (r) { return r.json(); })
      .then(function (items) {
        allItems = items;
        applyFilter();
      })
      .catch(function () { showState('empty'); });
  }

  // ── Filter + search ───────────────────────────────────────────────
  function applyFilter() {
    var q = searchInput.value.toLowerCase().trim();
    var filtered = allItems.filter(function (f) {
      if (f.type === 'folder') return activeFilter === 'all';
      if (activeFilter === 'images'    && f.type !== 'image')    return false;
      if (activeFilter === 'documents' && f.type !== 'document') return false;
      if (q && !f.name.toLowerCase().includes(q)) return false;
      return true;
    });
    renderGrid(filtered);
  }

  // ── Render grid ───────────────────────────────────────────────────
  function renderGrid(items) {
    grid.innerHTML = '';
    if (!items || items.length === 0) {
      showState('empty');
      statsEl.textContent = '';
      return;
    }
    showState('grid');

    var fileItems  = items.filter(function (i) { return i.type !== 'folder'; });
    var totalSize  = fileItems.reduce(function (acc, f) { return acc + f.size; }, 0);
    statsEl.textContent = fileItems.length + ' archivo' + (fileItems.length !== 1 ? 's' : '') +
                          (totalSize ? ' · ' + formatSize(totalSize) : '');

    items.forEach(function (item) {
      if (item.type === 'folder') {
        grid.appendChild(buildFolderCard(item));
      } else {
        grid.appendChild(buildFileCard(item));
      }
    });
  }

  // ── Folder card ───────────────────────────────────────────────────
  function buildFolderCard(item) {
    var col = document.createElement('div');
    col.className = 'col-6 col-sm-4 col-md-3 col-xl-2';
    col.innerHTML =
      '<div class="mm-folder-card">' +
        '<div class="mm-folder-thumb"><i class="bx bx-folder text-primary"></i></div>' +
        '<button type="button" class="btn btn-danger btn-sm mm-del-overlay" title="Eliminar carpeta">' +
          '<i class="bx bx-trash"></i>' +
        '</button>' +
        '<div class="p-2">' +
          '<div class="mm-file-name text-truncate" title="' + escHtml(item.name) + '">' + escHtml(item.name) + '</div>' +
          '<div class="mm-file-size">Carpeta</div>' +
        '</div>' +
      '</div>';

    col.querySelector('.mm-folder-card').addEventListener('click', function (e) {
      if (e.target.closest('.mm-del-overlay')) return;
      navigateTo(item.path);
      loadFolderTree();
    });

    col.querySelector('.mm-del-overlay').addEventListener('click', function (e) {
      e.stopPropagation();
      if (!confirm('¿Eliminar carpeta "' + item.name + '" y todo su contenido?')) return;
      fetch(folderDeleteUrl, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ path: item.path })
      })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d.success) {
            loadFolderTree();
            loadFiles();
            showToast('Carpeta eliminada');
          } else {
            showToast(d.message || 'Error al eliminar', 'danger');
          }
        });
    });

    return col;
  }

  // ── File card ─────────────────────────────────────────────────────
  function buildFileCard(f) {
    var col = document.createElement('div');
    col.className = 'col-6 col-sm-4 col-md-3 col-xl-2';
    col.setAttribute('data-name', f.name);

    var isImage = f.type === 'image';
    var docIcon = getDocIcon(f.ext);

    col.innerHTML =
      '<div class="mm-file-card">' +
        (isImage
          ? '<img src="' + escHtml(f.url) + '" class="mm-thumb" loading="lazy" alt="">'
          : '<div class="mm-doc-icon"><i class="bx ' + docIcon + ' text-muted"></i></div>') +
        '<button type="button" class="btn btn-danger btn-sm mm-del-overlay" title="Eliminar">' +
          '<i class="bx bx-trash"></i>' +
        '</button>' +
        '<div class="p-2">' +
          '<div class="mm-file-name text-truncate" title="' + escHtml(f.name) + '">' + escHtml(f.name) + '</div>' +
          '<div class="mm-file-size mb-2">' + formatSize(f.size) + ' &middot; ' + escHtml(f.ext.toUpperCase()) + '</div>' +
          '<div class="d-flex mm-actions flex-wrap">' +
            '<button type="button" class="btn btn-sm btn-outline-secondary mm-copy-btn" title="Copiar URL">' +
              '<i class="bx bx-link"></i>' +
            '</button>' +
            '<button type="button" class="btn btn-sm btn-outline-primary mm-rename-btn" title="Renombrar">' +
              '<i class="bx bx-pencil"></i>' +
            '</button>' +
          '</div>' +
        '</div>' +
      '</div>';

    col.querySelector('.mm-copy-btn').addEventListener('click', function () {
      navigator.clipboard.writeText(f.url).then(function () { showToast('URL copiada al portapapeles'); });
    });

    col.querySelector('.mm-rename-btn').addEventListener('click', function () {
      openRenameModal(f, col);
    });

    col.querySelector('.mm-del-overlay').addEventListener('click', function (e) {
      e.stopPropagation();
      deleteFile(f, col);
    });

    return col;
  }

  // ── Rename ────────────────────────────────────────────────────────
  function openRenameModal(f, cardEl) {
    renameTarget = { file: f, cardEl: cardEl };
    document.getElementById('rename-input').value = f.name.replace(/\.[^.]+$/, '');
    document.getElementById('rename-ext').textContent = '.' + f.ext;
    if (!renameModal) {
      renameModal = new bootstrap.Modal(document.getElementById('renameModal'));
    }
    renameModal.show();
    setTimeout(function () {
      var inp = document.getElementById('rename-input');
      inp.focus(); inp.select();
    }, 300);
  }

  document.getElementById('rename-confirm-btn').addEventListener('click', function () {
    if (!renameTarget) return;
    var newName = document.getElementById('rename-input').value.trim();
    if (!newName) return;
    var btn = this;
    btn.disabled = true;
    fetch(renameUrl, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ old_name: renameTarget.file.name, new_name: newName, path: currentPath })
    })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        btn.disabled = false;
        if (d.success) {
          var f = allItems.find(function (x) { return x.name === renameTarget.file.name; });
          if (f) { f.name = d.new_name; f.url = d.new_url; }
          var nameEl = renameTarget.cardEl.querySelector('.mm-file-name');
          if (nameEl) { nameEl.textContent = d.new_name; nameEl.title = d.new_name; }
          var img = renameTarget.cardEl.querySelector('.mm-thumb');
          if (img) img.src = d.new_url;
          if (renameModal) renameModal.hide();
          showToast('Archivo renombrado');
          renameTarget.file.name = d.new_name;
          renameTarget.file.url  = d.new_url;
        } else {
          showToast(d.message || 'Error al renombrar', 'danger');
        }
      })
      .catch(function () { btn.disabled = false; showToast('Error de red', 'danger'); });
  });

  document.getElementById('rename-input').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') document.getElementById('rename-confirm-btn').click();
  });

  // ── Delete file ───────────────────────────────────────────────────
  function deleteFile(f, cardEl) {
    if (!confirm('¿Eliminar "' + f.name + '"?\nEsta acción no se puede deshacer.')) return;
    fetch(deleteUrl, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ name: f.name, path: currentPath })
    })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (d.success) {
          allItems = allItems.filter(function (x) { return x.name !== f.name; });
          cardEl.remove();
          var remaining = grid.querySelectorAll('[data-name]').length;
          if (remaining === 0) showState('empty');
          var totalSize = allItems.reduce(function (acc, x) { return acc + x.size; }, 0);
          statsEl.textContent = remaining + ' archivo' + (remaining !== 1 ? 's' : '') +
                                (totalSize ? ' · ' + formatSize(totalSize) : '');
          showToast('Archivo eliminado');
        } else {
          showToast(d.message || 'Error al eliminar', 'danger');
        }
      })
      .catch(function () { showToast('Error de red', 'danger'); });
  }

  // ── Upload ────────────────────────────────────────────────────────
  function uploadFiles(fileList) {
    var files = Array.from(fileList);
    if (!files.length) return;

    var wrap  = document.getElementById('mm-progress-wrap');
    var label = document.getElementById('mm-progress-label');
    wrap.classList.remove('d-none');
    var done = 0; var total = files.length;

    function onDone() {
      done++;
      label.textContent = 'Subiendo ' + done + '/' + total + '…';
      if (done === total) {
        label.textContent = done + ' archivo' + (done > 1 ? 's subidos' : ' subido');
        setTimeout(function () { wrap.classList.add('d-none'); label.textContent = ''; }, 2000);
        loadFiles();
      }
    }

    files.forEach(function (file) {
      var fd = new FormData();
      fd.append('file', file);
      fd.append('_token', csrf);
      fd.append('path', currentPath);
      fetch(uploadUrl, { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (!d.success) showToast('Error subiendo ' + file.name, 'danger');
          onDone();
        })
        .catch(function () { showToast('Error de red subiendo ' + file.name, 'danger'); onDone(); });
    });
  }

  document.getElementById('mm-file-input').addEventListener('change', function () {
    uploadFiles(this.files); this.value = '';
  });

  var dropZone = document.getElementById('mm-drop-zone');
  ['dragenter', 'dragover'].forEach(function (evt) {
    dropZone.addEventListener(evt, function (e) { e.preventDefault(); dropZone.classList.add('drag-over'); });
  });
  ['dragleave', 'drop'].forEach(function (evt) {
    dropZone.addEventListener(evt, function (e) { e.preventDefault(); dropZone.classList.remove('drag-over'); });
  });
  dropZone.addEventListener('drop', function (e) { uploadFiles(e.dataTransfer.files); });

  // ── New folder ────────────────────────────────────────────────────
  document.getElementById('mm-new-folder-btn').addEventListener('click', function () {
    var name = prompt('Nombre de la nueva carpeta:');
    if (!name || !name.trim()) return;
    fetch(folderCreateUrl, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ name: name.trim(), path: currentPath })
    })
      .then(function (r) { return r.json(); })
      .then(function (d) {
        if (d.success) {
          showToast('Carpeta creada');
          loadFolderTree();
          loadFiles();
        } else {
          showToast(d.message || 'Error al crear carpeta', 'danger');
        }
      });
  });

  // ── Filter buttons ────────────────────────────────────────────────
  document.querySelectorAll('.mm-filter-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.mm-filter-btn').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      activeFilter = btn.dataset.filter;
      applyFilter();
    });
  });

  // ── Search ────────────────────────────────────────────────────────
  searchInput.addEventListener('input', function () { applyFilter(); });

  // ── Helpers ───────────────────────────────────────────────────────
  function showState(state) {
    loading.classList.add('d-none'); loading.classList.remove('d-flex');
    empty.classList.add('d-none');   empty.classList.remove('d-flex');
    grid.classList.add('d-none');
    if (state === 'loading') { loading.classList.remove('d-none'); loading.classList.add('d-flex'); }
    else if (state === 'empty') { empty.classList.remove('d-none'); empty.classList.add('d-flex'); }
    else { grid.classList.remove('d-none'); }
  }

  function formatSize(bytes) {
    if (!bytes) return '0 B';
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }

  function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  }

  function getDocIcon(ext) {
    var map = {
      pdf:'bxs-file-pdf', doc:'bxs-file-doc', docx:'bxs-file-doc',
      xls:'bx-spreadsheet', xlsx:'bx-spreadsheet',
      txt:'bxs-file-txt', csv:'bxs-file-txt', zip:'bxs-file-archive',
    };
    return map[ext] || 'bxs-file-blank';
  }

  function showToast(msg, type) {
    type = type || 'success';
    var toast = document.createElement('div');
    toast.className = 'toast align-items-center text-white bg-' +
      (type === 'danger' ? 'danger' : 'success') +
      ' border-0 position-fixed show';
    toast.style.cssText = 'bottom:20px;right:20px;z-index:9999;min-width:220px';
    toast.innerHTML =
      '<div class="d-flex"><div class="toast-body">' + escHtml(msg) + '</div>' +
      '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
    document.body.appendChild(toast);
    setTimeout(function () { toast.remove(); }, 3000);
    toast.querySelector('[data-bs-dismiss="toast"]').addEventListener('click', function () { toast.remove(); });
  }

  // ── Init ──────────────────────────────────────────────────────────
  loadFolderTree();
  loadFiles();

}());
</script>
@endsection
