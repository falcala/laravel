@php $items = $section->content['items'] ?? []; $secId = $section->id; @endphp

<div class="mb-3">
  <label class="form-label small">Columns</label>
  <select name="content[columns]" class="form-select form-select-sm" style="width:120px">
    @foreach([2,3,4] as $col)
      <option value="{{ $col }}" {{ ($section->content['columns'] ?? 3) == $col ? 'selected' : '' }}>
        {{ $col }} Columns
      </option>
    @endforeach
  </select>
</div>

<div id="feature-items-{{ $secId }}">
  @foreach($items as $i => $item)
  @php $iconVal = $item['icon'] ?? 'bx-star'; @endphp
  <div class="border rounded p-3 mb-2 feature-item">
    <div class="d-flex justify-content-between mb-2">
      <strong class="small">Feature {{ $i + 1 }}</strong>
      <button type="button" class="btn btn-sm btn-outline-danger remove-feature">
        <i class="bx bx-trash"></i>
      </button>
    </div>
    <div class="row g-2">

      {{-- Icon field --}}
      <div class="col-12">
        <label class="form-label small">Icon (Boxicon)</label>
        <div class="d-flex align-items-center gap-2">
          {{-- Live preview --}}
          <div class="icon-preview d-flex align-items-center justify-content-center border rounded"
               style="width:38px;height:38px;min-width:38px;background:#f8f8ff">
            <i class="bx {{ $iconVal }}" style="font-size:1.3rem;color:#696cff"></i>
          </div>
          {{-- Text input --}}
          <input type="text"
                 name="content[items][{{ $i }}][icon]"
                 class="form-control form-control-sm icon-input"
                 value="{{ $iconVal }}"
                 placeholder="bx-star">
          {{-- Picker button --}}
          <button type="button"
                  class="btn btn-outline-primary btn-sm icon-pick-btn flex-shrink-0">
            <i class="bx bx-grid-alt me-1"></i> Elegir
          </button>
        </div>
      </div>

      <div class="col-md-6">
        <label class="form-label small">Title</label>
        <input type="text" name="content[items][{{ $i }}][title]"
               class="form-control form-control-sm" value="{{ $item['title'] ?? '' }}" />
      </div>
      <div class="col-md-6">
        <label class="form-label small">Description</label>
        <input type="text" name="content[items][{{ $i }}][description]"
               class="form-control form-control-sm" value="{{ $item['description'] ?? '' }}" />
      </div>

    </div>
  </div>
  @endforeach
</div>

<button type="button" class="btn btn-outline-primary btn-sm w-100 mt-1 add-feature-btn"
        data-section="{{ $secId }}">
  <i class="bx bx-plus me-1"></i> Add Feature
</button>

{{-- ── Icon Picker Modal ────────────────────────────────────────────── --}}
<div class="modal fade" id="iconPickerModal-{{ $secId }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h6 class="modal-title mb-0">
          <i class="bx bx-grid-alt me-2 text-primary"></i>Seleccionar Ícono
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        {{-- Search --}}
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bx bx-search"></i></span>
          <input type="text" class="form-control icon-picker-search"
                 placeholder="Buscar ícono… (ej: rocket, mail, user)">
        </div>
        {{-- Grid --}}
        <div class="icon-picker-grid row g-2" style="max-height:420px;overflow-y:auto">
          {{-- Filled by JS --}}
        </div>
      </div>
      <div class="modal-footer py-2">
        <small class="text-muted me-auto icon-picker-count"></small>
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
(function () {
  var secId = '{{ $secId }}';
  var count = {{ count($items) }};

  // ── Full Boxicons list ───────────────────────────────────────────────
  var ICONS = [
    'bx-abacus','bx-accessibility','bx-add-to-queue','bx-adjust','bx-alarm',
    'bx-alarm-add','bx-alarm-exclamation','bx-alarm-off','bx-alarm-snooze',
    'bx-album','bx-align-justify','bx-align-left','bx-align-middle','bx-align-right',
    'bx-analyse','bx-anchor','bx-angry','bx-aperture','bx-arch','bx-archive',
    'bx-archive-in','bx-archive-out','bx-area','bx-arrow-back','bx-arrow-from-bottom',
    'bx-arrow-from-left','bx-arrow-from-right','bx-arrow-from-top','bx-arrow-to-bottom',
    'bx-arrow-to-left','bx-arrow-to-right','bx-arrow-to-top','bx-at','bx-atom',
    'bx-award','bx-badge','bx-badge-check','bx-ball','bx-band-aid','bx-bar-chart',
    'bx-bar-chart-alt','bx-bar-chart-alt-2','bx-bar-chart-square','bx-barcode',
    'bx-barcode-reader','bx-baseball','bx-basket','bx-basketball','bx-bath',
    'bx-battery','bx-bed','bx-been-here','bx-bell','bx-bell-minus','bx-bell-off',
    'bx-bell-plus','bx-bitcoin','bx-block','bx-bluetooth','bx-bold','bx-bolt-circle',
    'bx-book','bx-book-alt','bx-book-bookmark','bx-book-content','bx-book-heart',
    'bx-bookmark','bx-bookmark-alt','bx-bookmark-alt-minus','bx-bookmark-alt-plus',
    'bx-bookmark-heart','bx-bookmark-minus','bx-bookmark-plus','bx-bookmarks',
    'bx-border-all','bx-border-bottom','bx-border-inner','bx-border-left',
    'bx-border-none','bx-border-outer','bx-border-radius','bx-border-right',
    'bx-border-top','bx-bot','bx-bowling-ball','bx-box','bx-brain','bx-briefcase',
    'bx-briefcase-alt','bx-briefcase-alt-2','bx-brightness','bx-brightness-half',
    'bx-broadcast','bx-brush','bx-brush-alt','bx-bug','bx-bug-alt','bx-building',
    'bx-building-house','bx-buildings','bx-bulb','bx-buoy','bx-bus','bx-bus-school',
    'bx-cabinet','bx-cake','bx-calculator','bx-calendar','bx-calendar-alt',
    'bx-calendar-check','bx-calendar-edit','bx-calendar-event','bx-calendar-exclamation',
    'bx-calendar-heart','bx-calendar-minus','bx-calendar-plus','bx-calendar-star',
    'bx-calendar-week','bx-calendar-x','bx-camera','bx-camera-movie','bx-camera-off',
    'bx-captions','bx-car','bx-card','bx-caret-down','bx-caret-left','bx-caret-right',
    'bx-caret-up','bx-carousel','bx-cart','bx-cart-add','bx-cart-alt','bx-cart-download',
    'bx-cast','bx-category','bx-category-alt','bx-cctv','bx-certification','bx-chat',
    'bx-check','bx-check-circle','bx-check-double','bx-check-shield','bx-check-square',
    'bx-chevron-down','bx-chevron-down-circle','bx-chevron-down-square','bx-chevron-left',
    'bx-chevron-left-circle','bx-chevron-left-square','bx-chevron-right',
    'bx-chevron-right-circle','bx-chevron-right-square','bx-chevron-up',
    'bx-chevron-up-circle','bx-chevron-up-square','bx-chip','bx-church','bx-circle',
    'bx-clipboard','bx-closet','bx-cloud','bx-cloud-download','bx-cloud-drizzle',
    'bx-cloud-lightning','bx-cloud-rain','bx-cloud-snow','bx-cloud-upload','bx-code',
    'bx-code-alt','bx-code-block','bx-code-curly','bx-coffee','bx-coffee-togo',
    'bx-cog','bx-coin','bx-coin-stack','bx-collection','bx-columns','bx-command',
    'bx-comment','bx-comment-add','bx-comment-check','bx-comment-detail',
    'bx-comment-dots','bx-comment-edit','bx-comment-error','bx-comment-minus',
    'bx-comment-x','bx-compass','bx-confused','bx-connect','bx-conversation',
    'bx-cookie','bx-copy','bx-copy-alt','bx-copyright','bx-credit-card',
    'bx-credit-card-alt','bx-crop','bx-crosshair','bx-crown','bx-cube','bx-cube-alt',
    'bx-cuboid','bx-current-location','bx-customize','bx-cylinder',
    'bx-dashboard','bx-data','bx-desktop','bx-detail','bx-devices','bx-dialpad',
    'bx-dialpad-alt','bx-diamond','bx-dice-1','bx-dice-2','bx-dice-3',
    'bx-dice-4','bx-dice-5','bx-dice-6','bx-directions','bx-disc',
    'bx-dish','bx-dislike','bx-dna','bx-dock-bottom','bx-dock-left','bx-dock-right',
    'bx-dock-top','bx-dollar','bx-dollar-circle','bx-donate-blood','bx-donate-heart',
    'bx-door-open','bx-dots-horizontal','bx-dots-horizontal-rounded',
    'bx-dots-vertical','bx-dots-vertical-rounded','bx-doughnut-chart',
    'bx-down-arrow','bx-down-arrow-alt','bx-down-arrow-circle',
    'bx-download','bx-downvote','bx-drink','bx-droplet','bx-dumbbell','bx-duplicate',
    'bx-edit','bx-edit-alt','bx-envelope','bx-envelope-open','bx-equal',
    'bx-equalizer','bx-error','bx-error-alt','bx-error-circle','bx-euro',
    'bx-exit','bx-exit-fullscreen','bx-expand','bx-expand-alt','bx-export',
    'bx-face','bx-fast-forward','bx-fast-forward-circle','bx-female',
    'bx-female-sign','bx-file','bx-file-blank','bx-file-find','bx-filter',
    'bx-filter-alt','bx-fingerprint','bx-flag','bx-folder','bx-folder-minus',
    'bx-folder-open','bx-folder-plus','bx-font','bx-font-color','bx-font-family',
    'bx-font-size','bx-food-menu','bx-food-tag','bx-football','bx-fullscreen',
    'bx-git-branch','bx-git-commit','bx-git-compare','bx-git-merge',
    'bx-git-pull-request','bx-git-repo-forked','bx-globe','bx-globe-alt',
    'bx-grid','bx-grid-alt','bx-grid-horizontal','bx-grid-small','bx-grid-vertical',
    'bx-group','bx-handicap','bx-happy','bx-happy-alt','bx-happy-beaming',
    'bx-happy-heart-eyes','bx-hdd','bx-heading','bx-headphone','bx-health',
    'bx-heart','bx-heart-circle','bx-heart-square','bx-help-circle','bx-hide',
    'bx-highlight','bx-history','bx-hive','bx-home','bx-home-alt','bx-home-circle',
    'bx-home-heart','bx-home-smile','bx-horizontal-center','bx-hotel',
    'bx-hourglass','bx-id-card','bx-image','bx-image-add','bx-image-alt',
    'bx-images','bx-import','bx-infinite','bx-info-circle','bx-info-square',
    'bx-italic','bx-joystick','bx-joystick-alt','bx-joystick-button',
    'bx-key','bx-label','bx-landscape','bx-laptop','bx-last-page','bx-laugh',
    'bx-layer','bx-layer-minus','bx-layer-plus','bx-layout','bx-left-arrow',
    'bx-left-arrow-alt','bx-left-arrow-circle','bx-left-down-arrow-circle',
    'bx-left-indent','bx-left-top-arrow-circle','bx-like','bx-line-chart',
    'bx-line-chart-down','bx-link','bx-link-alt','bx-link-external','bx-lira',
    'bx-list-check','bx-list-minus','bx-list-ol','bx-list-plus','bx-list-ul',
    'bx-loader','bx-loader-alt','bx-loader-circle','bx-location-plus',
    'bx-lock','bx-lock-alt','bx-lock-open','bx-lock-open-alt','bx-log-in',
    'bx-log-in-circle','bx-log-out','bx-log-out-circle','bx-low-vision',
    'bx-magic-wand','bx-magnet','bx-mail-send','bx-male','bx-male-sign',
    'bx-map','bx-map-alt','bx-map-pin','bx-medal','bx-menu','bx-menu-alt-left',
    'bx-menu-alt-right','bx-merge','bx-message','bx-message-add','bx-message-alt',
    'bx-message-alt-add','bx-message-alt-check','bx-message-alt-detail',
    'bx-message-alt-dots','bx-message-alt-edit','bx-message-alt-error',
    'bx-message-alt-minus','bx-message-alt-x','bx-message-check','bx-message-detail',
    'bx-message-dots','bx-message-edit','bx-message-error','bx-message-minus',
    'bx-message-rounded','bx-message-rounded-add','bx-message-rounded-check',
    'bx-message-rounded-detail','bx-message-rounded-dots','bx-message-rounded-edit',
    'bx-message-rounded-error','bx-message-rounded-minus','bx-message-rounded-x',
    'bx-message-square','bx-message-square-add','bx-message-square-check',
    'bx-message-square-detail','bx-message-square-dots','bx-message-square-edit',
    'bx-message-square-error','bx-message-square-minus','bx-message-square-x',
    'bx-message-x','bx-microphone','bx-microphone-off','bx-minus','bx-minus-back',
    'bx-minus-circle','bx-minus-front','bx-mobile','bx-mobile-alt','bx-mobile-landscape',
    'bx-mobile-vibration','bx-money','bx-money-withdraw','bx-moon','bx-mouse',
    'bx-mouse-alt','bx-move','bx-move-horizontal','bx-move-vertical','bx-movie',
    'bx-movie-play','bx-music','bx-navigation','bx-network-chart','bx-news',
    'bx-no-entry','bx-note','bx-notepad','bx-notification','bx-notification-off',
    'bx-package','bx-paint','bx-paint-roll','bx-palette','bx-paperclip',
    'bx-paragraph','bx-paste','bx-pause','bx-pause-circle','bx-pen',
    'bx-pencil','bx-phone','bx-phone-call','bx-phone-incoming','bx-phone-off',
    'bx-phone-outgoing','bx-photo-album','bx-pie-chart','bx-pie-chart-alt',
    'bx-pie-chart-alt-2','bx-pin','bx-planet','bx-play','bx-play-circle',
    'bx-plug','bx-plus','bx-plus-circle','bx-plus-medical','bx-pointer',
    'bx-poll','bx-polygon','bx-pool','bx-power-off','bx-printer','bx-purchase-tag',
    'bx-purchase-tag-alt','bx-pyramid','bx-qr','bx-qr-scan','bx-question-mark',
    'bx-radio','bx-radio-circle','bx-radio-circle-marked','bx-receipt',
    'bx-rectangle','bx-recycle','bx-redo','bx-refresh','bx-registered',
    'bx-rename','bx-reply','bx-reply-all','bx-repost','bx-reset','bx-restaurant',
    'bx-revision','bx-rewind','bx-rewind-circle','bx-right-arrow','bx-right-arrow-alt',
    'bx-right-arrow-circle','bx-right-down-arrow-circle','bx-right-indent',
    'bx-right-top-arrow-circle','bx-rocket','bx-rotate-left','bx-rotate-right',
    'bx-rss','bx-ruler','bx-run','bx-sad','bx-save','bx-scan','bx-screenshot',
    'bx-search','bx-search-alt','bx-search-alt-2','bx-selection','bx-send',
    'bx-server','bx-shape-circle','bx-shape-polygon','bx-shape-square',
    'bx-shape-triangle','bx-share','bx-share-alt','bx-shield','bx-shield-alt',
    'bx-shield-alt-2','bx-shield-quarter','bx-shield-x','bx-show','bx-shuffle',
    'bx-sidebar','bx-sitemap','bx-skip-next','bx-skip-next-circle',
    'bx-skip-previous','bx-skip-previous-circle','bx-sleepy','bx-slider',
    'bx-slider-alt','bx-slideshow','bx-smile','bx-sort','bx-sort-a-z',
    'bx-sort-alt-2','bx-sort-down','bx-sort-up','bx-sort-z-a','bx-spa',
    'bx-space-bar','bx-spray-can','bx-spreadsheet','bx-star','bx-station',
    'bx-stats','bx-sticker','bx-stop','bx-stop-circle','bx-stopwatch',
    'bx-store','bx-store-alt','bx-street-view','bx-strikethrough','bx-subdirectory-left',
    'bx-subdirectory-right','bx-sun','bx-support','bx-swim','bx-sync',
    'bx-tab','bx-table','bx-tachometer','bx-tag','bx-tag-alt','bx-target-lock',
    'bx-task','bx-task-x','bx-terminal','bx-test-tube','bx-text','bx-time',
    'bx-time-five','bx-timer','bx-tired','bx-toggle-left','bx-toggle-right',
    'bx-tone','bx-transfer','bx-transfer-alt','bx-trash','bx-trash-alt',
    'bx-trending-down','bx-trending-up','bx-trophy','bx-tv','bx-underline',
    'bx-undo','bx-unite','bx-unlink','bx-up-arrow','bx-up-arrow-alt',
    'bx-up-arrow-circle','bx-upload','bx-upvote','bx-usb','bx-user',
    'bx-user-check','bx-user-circle','bx-user-minus','bx-user-pin','bx-user-plus',
    'bx-user-voice','bx-user-x','bx-vector','bx-video','bx-video-off',
    'bx-video-plus','bx-video-recording','bx-voicemail','bx-volume',
    'bx-volume-full','bx-volume-low','bx-volume-mute','bx-walk','bx-wallet',
    'bx-wallet-alt','bx-water','bx-webcam','bx-wifi','bx-wifi-0','bx-wifi-1',
    'bx-wifi-2','bx-wifi-off','bx-wind','bx-window','bx-window-alt',
    'bx-window-close','bx-window-open','bx-windows','bx-wink-smile',
    'bx-wink-tongue','bx-won','bx-world','bx-wrench','bx-x','bx-x-circle',
    'bx-yen','bx-zoom-in','bx-zoom-out',
    // Solid (bxs-)
    'bxs-alarm','bxs-alarm-add','bxs-album','bxs-ambulance','bxs-analyse',
    'bxs-angry','bxs-award','bxs-baby-carriage','bxs-badge','bxs-badge-check',
    'bxs-ball','bxs-band-aid','bxs-bar-chart-alt-2','bxs-bar-chart-square',
    'bxs-barcode','bxs-baseball','bxs-basket','bxs-basketball','bxs-bath',
    'bxs-battery','bxs-bed','bxs-been-here','bxs-bell','bxs-bell-minus',
    'bxs-bell-off','bxs-bell-plus','bxs-bell-ring','bxs-bible','bxs-binoculars',
    'bxs-book','bxs-book-alt','bxs-book-bookmark','bxs-book-content','bxs-book-heart',
    'bxs-bookmark','bxs-bookmark-alt-minus','bxs-bookmark-alt-plus','bxs-bookmark-heart',
    'bxs-bookmark-minus','bxs-bookmark-plus','bxs-bookmarks','bxs-bot',
    'bxs-bowling-ball','bxs-box','bxs-brain','bxs-briefcase','bxs-briefcase-alt-2',
    'bxs-brush','bxs-brush-alt','bxs-bug','bxs-bug-alt','bxs-building',
    'bxs-building-house','bxs-buildings','bxs-bulb','bxs-buoy','bxs-bus',
    'bxs-cabinet','bxs-cake','bxs-calculator','bxs-calendar','bxs-calendar-alt',
    'bxs-calendar-check','bxs-calendar-edit','bxs-calendar-event','bxs-calendar-exclamation',
    'bxs-calendar-heart','bxs-calendar-minus','bxs-calendar-plus','bxs-calendar-star',
    'bxs-calendar-week','bxs-calendar-x','bxs-camera','bxs-camera-movie',
    'bxs-camera-off','bxs-captions','bxs-car','bxs-card','bxs-cart',
    'bxs-cart-add','bxs-cart-alt','bxs-cart-download','bxs-category',
    'bxs-category-alt','bxs-certification','bxs-chat','bxs-check-circle',
    'bxs-check-shield','bxs-check-square','bxs-chess','bxs-chip','bxs-circle',
    'bxs-city','bxs-clinic','bxs-cloud','bxs-cloud-download','bxs-cloud-lightning',
    'bxs-cloud-rain','bxs-cloud-upload','bxs-coffee','bxs-coffee-togo',
    'bxs-cog','bxs-coin-stack','bxs-collection','bxs-color-fill','bxs-comment',
    'bxs-comment-add','bxs-comment-check','bxs-comment-detail','bxs-comment-dots',
    'bxs-comment-edit','bxs-comment-error','bxs-comment-minus','bxs-comment-x',
    'bxs-compass','bxs-confused','bxs-contact','bxs-cookie','bxs-copy',
    'bxs-credit-card','bxs-credit-card-alt','bxs-crown','bxs-cube','bxs-cube-alt',
    'bxs-customize','bxs-cylinder','bxs-dashboard','bxs-data','bxs-detail',
    'bxs-devices','bxs-diamond','bxs-direction-left','bxs-direction-right',
    'bxs-directions','bxs-disc','bxs-dish','bxs-dislike','bxs-dizzy',
    'bxs-dock-top','bxs-dollar-circle','bxs-donate-blood','bxs-donate-heart',
    'bxs-door-open','bxs-doughnut-chart','bxs-down-arrow','bxs-down-arrow-circle',
    'bxs-download','bxs-downvote','bxs-drink','bxs-droplet','bxs-droplet-half',
    'bxs-dumbbell','bxs-duplicate','bxs-edit','bxs-edit-alt','bxs-envelope',
    'bxs-envelope-open','bxs-error','bxs-error-alt','bxs-error-circle',
    'bxs-face','bxs-factory','bxs-file','bxs-file-archive','bxs-file-blank',
    'bxs-file-css','bxs-file-doc','bxs-file-export','bxs-file-find','bxs-file-gif',
    'bxs-file-html','bxs-file-image','bxs-file-import','bxs-file-jpg',
    'bxs-file-js','bxs-file-json','bxs-file-md','bxs-file-pdf','bxs-file-plus',
    'bxs-file-png','bxs-file-txt','bxs-film','bxs-filter-alt','bxs-first-aid',
    'bxs-flag','bxs-flag-alt','bxs-flashlight','bxs-floppy','bxs-folder',
    'bxs-folder-minus','bxs-folder-open','bxs-folder-plus','bxs-food-menu',
    'bxs-football','bxs-ghost','bxs-gift','bxs-globe','bxs-graduation',
    'bxs-grid','bxs-grid-alt','bxs-group','bxs-happy','bxs-happy-alt',
    'bxs-happy-beaming','bxs-happy-heart-eyes','bxs-hdd','bxs-heart',
    'bxs-heart-circle','bxs-heart-square','bxs-help-circle','bxs-hide',
    'bxs-home','bxs-home-circle','bxs-home-heart','bxs-home-smile','bxs-hotel',
    'bxs-hourglass','bxs-id-card','bxs-image','bxs-image-add','bxs-image-alt',
    'bxs-inbox','bxs-info-circle','bxs-info-square','bxs-joystick','bxs-joystick-alt',
    'bxs-joystick-button','bxs-key','bxs-label','bxs-landscape','bxs-laugh',
    'bxs-layer','bxs-layer-minus','bxs-layer-plus','bxs-layout','bxs-like',
    'bxs-lock','bxs-lock-alt','bxs-lock-open','bxs-lock-open-alt','bxs-log-in',
    'bxs-log-in-circle','bxs-log-out','bxs-log-out-circle','bxs-low-vision',
    'bxs-magic-wand','bxs-magnet','bxs-map','bxs-map-alt','bxs-map-pin',
    'bxs-medal','bxs-megaphone','bxs-memory-card','bxs-message','bxs-message-add',
    'bxs-message-alt-add','bxs-message-alt-check','bxs-message-alt-detail',
    'bxs-message-alt-dots','bxs-message-alt-edit','bxs-message-alt-error',
    'bxs-message-alt-minus','bxs-message-alt-x','bxs-message-check',
    'bxs-message-detail','bxs-message-dots','bxs-message-edit','bxs-message-error',
    'bxs-message-minus','bxs-message-rounded','bxs-message-rounded-add',
    'bxs-message-rounded-check','bxs-message-rounded-detail','bxs-message-rounded-dots',
    'bxs-message-rounded-edit','bxs-message-rounded-error','bxs-message-rounded-minus',
    'bxs-message-rounded-x','bxs-message-square','bxs-message-square-add',
    'bxs-message-square-check','bxs-message-square-detail','bxs-message-square-dots',
    'bxs-message-square-edit','bxs-message-square-error','bxs-message-square-minus',
    'bxs-message-square-x','bxs-message-x','bxs-microphone','bxs-microphone-off',
    'bxs-minus-circle','bxs-mobile','bxs-mobile-landscape','bxs-mobile-vibration',
    'bxs-moon','bxs-mouse','bxs-mouse-alt','bxs-movie','bxs-movie-play',
    'bxs-music','bxs-navigation','bxs-network-chart','bxs-news','bxs-no-entry',
    'bxs-note','bxs-notepad','bxs-notification','bxs-notification-off',
    'bxs-package','bxs-paint','bxs-paint-roll','bxs-palette','bxs-paperclip',
    'bxs-parking','bxs-paste','bxs-pen','bxs-pencil','bxs-phone',
    'bxs-phone-call','bxs-phone-incoming','bxs-phone-off','bxs-phone-outgoing',
    'bxs-photo-album','bxs-pie-chart','bxs-pie-chart-alt','bxs-pie-chart-alt-2',
    'bxs-pin','bxs-pizza','bxs-plane','bxs-planet','bxs-play-circle',
    'bxs-plug','bxs-plus-circle','bxs-plus-square','bxs-pointer',
    'bxs-poll','bxs-printer','bxs-purchase-tag','bxs-purchase-tag-alt',
    'bxs-pyramid','bxs-quote-alt-left','bxs-quote-alt-right','bxs-quote-left',
    'bxs-quote-right','bxs-receipt','bxs-rectangle','bxs-rename','bxs-report',
    'bxs-rewind-circle','bxs-right-arrow','bxs-right-arrow-circle','bxs-right-arrow-square',
    'bxs-rocket','bxs-ruler','bxs-sad','bxs-save','bxs-school','bxs-search-alt-2',
    'bxs-select-multiple','bxs-send','bxs-server','bxs-shapes','bxs-share',
    'bxs-share-alt','bxs-shield','bxs-shield-alt-2','bxs-shield-x',
    'bxs-ship','bxs-shop','bxs-show','bxs-skip-next-circle','bxs-skip-previous-circle',
    'bxs-sleepy','bxs-slider','bxs-smile','bxs-sort-alt','bxs-spa',
    'bxs-spreadsheet','bxs-square','bxs-square-rounded','bxs-star','bxs-star-half',
    'bxs-sticker','bxs-stopwatch','bxs-store','bxs-store-alt','bxs-sun',
    'bxs-tag','bxs-tag-alt','bxs-target-lock','bxs-taxi','bxs-terminal',
    'bxs-time','bxs-time-five','bxs-timer','bxs-tired','bxs-toggle-left',
    'bxs-toggle-right','bxs-tone','bxs-traffic-barrier','bxs-train','bxs-trash',
    'bxs-trash-alt','bxs-trending-down','bxs-trending-up','bxs-trophy',
    'bxs-truck','bxs-tv','bxs-up-arrow','bxs-up-arrow-circle','bxs-upvote',
    'bxs-user','bxs-user-account','bxs-user-badge','bxs-user-check',
    'bxs-user-circle','bxs-user-detail','bxs-user-minus','bxs-user-pin',
    'bxs-user-plus','bxs-user-rectangle','bxs-user-voice','bxs-user-x',
    'bxs-vector','bxs-video','bxs-video-off','bxs-video-plus','bxs-video-recording',
    'bxs-videos','bxs-volume','bxs-volume-full','bxs-volume-low','bxs-volume-mute',
    'bxs-wallet','bxs-wallet-alt','bxs-watch','bxs-webcam','bxs-wine',
    'bxs-wink-smile','bxs-wink-tongue','bxs-wrench','bxs-x-circle','bxs-zap',
    'bxs-zoom-in','bxs-zoom-out'
  ];

  // ── Active picker target ───────────────────────────────────────────
  var activeItem = null; // the .feature-item currently picking
  var pickerModal = null;

  // ── Init icon preview + picker for a .feature-item ────────────────
  function initItem(item) {
    var iconInput   = item.querySelector('.icon-input');
    var iconPreview = item.querySelector('.icon-preview i');
    var pickBtn     = item.querySelector('.icon-pick-btn');

    // Live preview as user types
    iconInput.addEventListener('input', function () {
      var cls = (this.value || 'bx-star').trim();
      iconPreview.className = 'bx ' + cls;
    });

    // Open picker
    pickBtn.addEventListener('click', function () {
      activeItem = item;
      openPicker();
    });
  }

  // ── Open the picker modal ──────────────────────────────────────────
  function openPicker() {
    if (!pickerModal) {
      pickerModal = new bootstrap.Modal(
        document.getElementById('iconPickerModal-' + secId)
      );
    }

    // Reset search and render all
    var searchEl = document.querySelector('#iconPickerModal-' + secId + ' .icon-picker-search');
    searchEl.value = '';
    renderPickerGrid(ICONS);

    pickerModal.show();

    setTimeout(function () { searchEl.focus(); }, 300);
  }

  // ── Render the icon grid (filtered) ───────────────────────────────
  function renderPickerGrid(icons) {
    var grid  = document.querySelector('#iconPickerModal-' + secId + ' .icon-picker-grid');
    var count = document.querySelector('#iconPickerModal-' + secId + ' .icon-picker-count');
    grid.innerHTML = '';
    count.textContent = icons.length + ' íconos';

    icons.forEach(function (ic) {
      var col = document.createElement('div');
      col.className = 'col-3 col-sm-2 col-md-1';
      col.innerHTML =
        '<div class="border rounded p-2 text-center icon-option" ' +
             'data-icon="' + ic + '" ' +
             'style="cursor:pointer;transition:background .15s" ' +
             'title="' + ic + '">' +
          '<i class="bx ' + ic + '" style="font-size:1.5rem;color:#696cff;display:block"></i>' +
          '<div style="font-size:9px;color:#888;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin-top:2px">' +
            ic.replace(/^bxs?-/, '') +
          '</div>' +
        '</div>';

      var opt = col.querySelector('.icon-option');
      opt.addEventListener('mouseenter', function () { this.style.background = '#f0f0ff'; });
      opt.addEventListener('mouseleave', function () { this.style.background = ''; });
      opt.addEventListener('click', function () { selectIcon(ic); });

      grid.appendChild(col);
    });
  }

  // ── Select an icon from the picker ────────────────────────────────
  function selectIcon(ic) {
    if (!activeItem) return;
    var iconInput   = activeItem.querySelector('.icon-input');
    var iconPreview = activeItem.querySelector('.icon-preview i');

    iconInput.value   = ic;
    iconPreview.className = 'bx ' + ic;

    if (pickerModal) pickerModal.hide();
  }

  // ── Search in picker ──────────────────────────────────────────────
  document.querySelector('#iconPickerModal-' + secId + ' .icon-picker-search')
    .addEventListener('input', function () {
      var q = this.value.toLowerCase().trim();
      var filtered = q ? ICONS.filter(function (ic) { return ic.includes(q); }) : ICONS;
      renderPickerGrid(filtered);
    });

  // ── Init existing items ───────────────────────────────────────────
  document.querySelectorAll('#feature-items-' + secId + ' .feature-item').forEach(initItem);

  // ── Add feature ───────────────────────────────────────────────────
  document.querySelector('.add-feature-btn[data-section="' + secId + '"]')
    .addEventListener('click', function () {
      var idx = count++;
      var html =
        '<div class="border rounded p-3 mb-2 feature-item">' +
          '<div class="d-flex justify-content-between mb-2">' +
            '<strong class="small">Feature ' + (idx + 1) + '</strong>' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-feature">' +
              '<i class="bx bx-trash"></i>' +
            '</button>' +
          '</div>' +
          '<div class="row g-2">' +
            '<div class="col-12">' +
              '<label class="form-label small">Icon (Boxicon)</label>' +
              '<div class="d-flex align-items-center gap-2">' +
                '<div class="icon-preview d-flex align-items-center justify-content-center border rounded" ' +
                     'style="width:38px;height:38px;min-width:38px;background:#f8f8ff">' +
                  '<i class="bx bx-star" style="font-size:1.3rem;color:#696cff"></i>' +
                '</div>' +
                '<input type="text" name="content[items][' + idx + '][icon]" ' +
                       'class="form-control form-control-sm icon-input" ' +
                       'value="bx-star" placeholder="bx-star">' +
                '<button type="button" class="btn btn-outline-primary btn-sm icon-pick-btn flex-shrink-0">' +
                  '<i class="bx bx-grid-alt me-1"></i> Elegir' +
                '</button>' +
              '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
              '<label class="form-label small">Title</label>' +
              '<input type="text" name="content[items][' + idx + '][title]" class="form-control form-control-sm">' +
            '</div>' +
            '<div class="col-md-6">' +
              '<label class="form-label small">Description</label>' +
              '<input type="text" name="content[items][' + idx + '][description]" class="form-control form-control-sm">' +
            '</div>' +
          '</div>' +
        '</div>';

      var container = document.getElementById('feature-items-' + secId);
      container.insertAdjacentHTML('beforeend', html);
      var newItem = container.lastElementChild;
      initItem(newItem);
      bindRemove(newItem);
    });

  // ── Remove ────────────────────────────────────────────────────────
  function bindRemove(item) {
    var btn = item.querySelector('.remove-feature');
    if (btn) btn.onclick = function () { item.remove(); };
  }
  document.querySelectorAll('#feature-items-' + secId + ' .feature-item').forEach(bindRemove);

}());
</script>
