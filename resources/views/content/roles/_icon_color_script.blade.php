<script>
(function () {
  var ICONS = [
    'bx-accessibility','bx-add-to-queue','bx-adjust','bx-alarm','bx-album','bx-align-justify',
    'bx-align-left','bx-align-middle','bx-align-right','bx-ambulance','bx-anchor','bx-angry',
    'bx-aperture','bx-archive','bx-area','bx-arrow-back','bx-at','bx-award','bx-badge',
    'bx-badge-check','bx-bar-chart','bx-bar-chart-alt-2','bx-bar-chart-square','bx-barcode',
    'bx-basket','bx-bath','bx-battery','bx-bed','bx-been-here','bx-bell','bx-bell-minus',
    'bx-bell-off','bx-bell-plus','bx-block','bx-bluetooth','bx-bold','bx-bolt-circle',
    'bx-book','bx-book-alt','bx-book-bookmark','bx-book-content','bx-book-open','bx-book-reader',
    'bx-bookmark','bx-bookmark-heart','bx-bookmark-plus','bx-bookmarks','bx-bot','bx-box',
    'bx-briefcase','bx-briefcase-alt-2','bx-brightness','bx-broadcast','bx-brush','bx-bug',
    'bx-building','bx-building-house','bx-buildings','bx-bulb','bx-bullseye','bx-bus',
    'bx-cabinet','bx-cake','bx-calculator','bx-calendar','bx-calendar-alt','bx-calendar-check',
    'bx-calendar-event','bx-calendar-heart','bx-calendar-plus','bx-calendar-star',
    'bx-camera','bx-camera-movie','bx-capsule','bx-car','bx-card','bx-caret-down',
    'bx-caret-left','bx-caret-right','bx-caret-up','bx-cart','bx-cart-add','bx-cart-alt',
    'bx-cast','bx-category','bx-category-alt','bx-certification','bx-chart','bx-chat',
    'bx-check','bx-check-circle','bx-check-double','bx-check-shield','bx-check-square',
    'bx-chip','bx-church','bx-circle','bx-clipboard','bx-cloud','bx-cloud-download',
    'bx-cloud-rain','bx-cloud-upload','bx-code','bx-code-alt','bx-code-block','bx-code-curly',
    'bx-coffee','bx-cog','bx-coin','bx-coin-stack','bx-collection','bx-color-fill',
    'bx-columns','bx-command','bx-comment','bx-comment-add','bx-comment-check',
    'bx-comment-detail','bx-comment-dots','bx-compass','bx-conversation','bx-cool',
    'bx-copy','bx-copyright','bx-credit-card','bx-credit-card-alt','bx-crown','bx-cube',
    'bx-current-location','bx-customize','bx-cut','bx-cycling','bx-data','bx-desktop',
    'bx-detail','bx-devices','bx-dialpad','bx-diamond','bx-disc','bx-dish','bx-dislike',
    'bx-dizzy','bx-dna','bx-dollar','bx-dollar-circle','bx-donate-blood','bx-donate-heart',
    'bx-door-open','bx-dots-horizontal-rounded','bx-dots-vertical-rounded','bx-doughnut-chart',
    'bx-download','bx-drag','bx-drink','bx-droplet','bx-dumbbell','bx-duplicate',
    'bx-edit','bx-edit-alt','bx-envelope','bx-envelope-open','bx-equalizer','bx-error',
    'bx-error-circle','bx-euro','bx-exclude','bx-exit','bx-expand','bx-export',
    'bx-extension','bx-face','bx-fast-forward','bx-file','bx-file-blank','bx-file-find',
    'bx-film','bx-filter','bx-filter-alt','bx-fingerprint','bx-first-aid','bx-flag',
    'bx-flame','bx-food-menu','bx-football','bx-font','bx-fullscreen','bx-frown',
    'bx-game','bx-gift','bx-git-branch','bx-git-commit','bx-git-merge','bx-git-pull-request',
    'bx-glasses','bx-globe','bx-globe-alt','bx-grid','bx-grid-alt','bx-group',
    'bx-happy','bx-happy-beaming','bx-happy-heart-eyes','bx-hard-drive','bx-hash',
    'bx-heart','bx-heart-circle','bx-help-circle','bx-hide','bx-highlight','bx-history',
    'bx-home','bx-home-alt','bx-home-circle','bx-home-heart','bx-hotel','bx-hourglass',
    'bx-id-card','bx-image','bx-image-add','bx-images','bx-import','bx-infinite',
    'bx-info-circle','bx-italic','bx-joystick','bx-key','bx-label','bx-laptop',
    'bx-laugh','bx-layer','bx-layout','bx-left-arrow-alt','bx-like','bx-line-chart',
    'bx-link','bx-link-external','bx-list-check','bx-list-ol','bx-list-plus','bx-list-ul',
    'bx-loader-circle','bx-lock','bx-lock-alt','bx-lock-open','bx-log-in','bx-log-out',
    'bx-magic-wand','bx-magnet','bx-mail-send','bx-male','bx-map','bx-map-alt','bx-map-pin',
    'bx-medal','bx-memory-card','bx-menu','bx-menu-alt-left','bx-menu-alt-right','bx-merge',
    'bx-message','bx-message-add','bx-message-alt-dots','bx-message-check','bx-message-dots',
    'bx-microphone','bx-microphone-off','bx-minus','bx-minus-circle','bx-mobile',
    'bx-mobile-alt','bx-money','bx-moon','bx-mouse','bx-move','bx-music','bx-navigation',
    'bx-network-chart','bx-news','bx-no-entry','bx-note','bx-notepad','bx-notification',
    'bx-package','bx-paint','bx-paint-roll','bx-palette','bx-paperclip','bx-paragraph',
    'bx-paste','bx-pause','bx-pause-circle','bx-pen','bx-pencil','bx-phone',
    'bx-phone-call','bx-phone-incoming','bx-phone-off','bx-phone-outgoing','bx-photo-album',
    'bx-pie-chart','bx-pie-chart-alt-2','bx-pin','bx-planet','bx-play','bx-play-circle',
    'bx-plug','bx-plus','bx-plus-circle','bx-plus-medical','bx-pointer','bx-poll',
    'bx-power-off','bx-printer','bx-pulse','bx-purchase-tag','bx-purchase-tag-alt',
    'bx-qr','bx-qr-scan','bx-question-mark','bx-radar','bx-radio','bx-receipt',
    'bx-recycle','bx-redo','bx-refresh','bx-rename','bx-repeat','bx-reply','bx-reply-all',
    'bx-reset','bx-restaurant','bx-revision','bx-rewind','bx-right-arrow-alt',
    'bx-rocket','bx-rotate-left','bx-rotate-right','bx-rss','bx-ruler','bx-run',
    'bx-sad','bx-save','bx-scan','bx-search','bx-search-alt','bx-send','bx-server',
    'bx-share','bx-share-alt','bx-shield','bx-shield-alt','bx-shield-alt-2',
    'bx-shield-minus','bx-shield-plus','bx-shield-quarter','bx-shield-x','bx-show',
    'bx-shuffle','bx-sitemap','bx-skip-next','bx-skip-previous','bx-sleepy','bx-slider',
    'bx-slideshow','bx-smile','bx-sort','bx-sort-a-z','bx-sort-down','bx-sort-up',
    'bx-spa','bx-spreadsheet','bx-star','bx-station','bx-stats','bx-stop','bx-stop-circle',
    'bx-store','bx-store-alt','bx-street-view','bx-sun','bx-support','bx-sync','bx-tab',
    'bx-table','bx-tag','bx-tag-alt','bx-target-lock','bx-task','bx-task-x',
    'bx-terminal','bx-test-tube','bx-time','bx-time-five','bx-timer','bx-tired',
    'bx-toggle-left','bx-toggle-right','bx-torch','bx-trademark','bx-train','bx-transfer',
    'bx-trash','bx-trash-alt','bx-trending-down','bx-trending-up','bx-trophy','bx-tv',
    'bx-underline','bx-undo','bx-up-arrow-alt','bx-upload','bx-usb','bx-user',
    'bx-user-check','bx-user-circle','bx-user-minus','bx-user-pin','bx-user-plus',
    'bx-user-voice','bx-user-x','bx-video','bx-video-off','bx-video-plus','bx-voicemail',
    'bx-volume','bx-volume-full','bx-volume-mute','bx-walk','bx-wallet','bx-water',
    'bx-wifi','bx-window','bx-windows','bx-wink-smile','bx-won','bx-world','bx-wrench',
    'bx-x','bx-x-circle','bx-yen','bx-zoom-in','bx-zoom-out',
    'bxs-alarm','bxs-album','bxs-ambulance','bxs-award','bxs-badge','bxs-badge-check',
    'bxs-basket','bxs-bath','bxs-battery','bxs-bed','bxs-been-here','bxs-bell',
    'bxs-bell-minus','bxs-bell-off','bxs-bell-plus','bxs-bolt-circle','bxs-book',
    'bxs-book-alt','bxs-book-bookmark','bxs-book-content','bxs-book-heart','bxs-book-open',
    'bxs-bookmark','bxs-bookmark-heart','bxs-bookmark-plus','bxs-bookmarks','bxs-bot',
    'bxs-box','bxs-briefcase','bxs-bug','bxs-building','bxs-building-house','bxs-buildings',
    'bxs-bulb','bxs-bullseye','bxs-bus','bxs-cabinet','bxs-cake','bxs-calculator',
    'bxs-calendar','bxs-calendar-alt','bxs-calendar-check','bxs-calendar-event',
    'bxs-calendar-heart','bxs-calendar-plus','bxs-calendar-star','bxs-camera',
    'bxs-camera-movie','bxs-capsule','bxs-car','bxs-card','bxs-cart','bxs-cart-add',
    'bxs-certification','bxs-chart','bxs-chat','bxs-check-circle','bxs-check-shield',
    'bxs-check-square','bxs-chip','bxs-church','bxs-circle','bxs-city','bxs-clipboard',
    'bxs-cloud','bxs-cloud-download','bxs-cloud-lightning','bxs-cloud-rain','bxs-cloud-upload',
    'bxs-coffee','bxs-cog','bxs-coin','bxs-coin-stack','bxs-collection','bxs-color-fill',
    'bxs-comment','bxs-comment-add','bxs-comment-check','bxs-comment-detail',
    'bxs-comment-dots','bxs-compass','bxs-contact','bxs-conversation','bxs-copy',
    'bxs-credit-card','bxs-crown','bxs-cube','bxs-data','bxs-dashboard','bxs-diamond',
    'bxs-direction-left','bxs-direction-right','bxs-directions','bxs-disc','bxs-dish',
    'bxs-dislike','bxs-dizzy','bxs-dollar-circle','bxs-donate-blood','bxs-donate-heart',
    'bxs-door-open','bxs-doughnut-chart','bxs-download','bxs-drink','bxs-droplet',
    'bxs-dumbbell','bxs-duplicate','bxs-edit','bxs-edit-alt','bxs-envelope',
    'bxs-envelope-open','bxs-error','bxs-error-alt','bxs-error-circle','bxs-extension',
    'bxs-face','bxs-factory','bxs-file','bxs-file-archive','bxs-file-blank','bxs-file-css',
    'bxs-file-doc','bxs-file-image','bxs-file-pdf','bxs-file-txt','bxs-film',
    'bxs-filter-alt','bxs-first-aid','bxs-flag','bxs-flame','bxs-flask','bxs-florist',
    'bxs-folder','bxs-folder-minus','bxs-folder-open','bxs-folder-plus','bxs-food-menu',
    'bxs-gift','bxs-globe','bxs-globe-alt','bxs-graduation','bxs-group','bxs-hand',
    'bxs-happy','bxs-happy-beaming','bxs-happy-heart-eyes','bxs-hard-hat','bxs-heart',
    'bxs-heart-circle','bxs-help-circle','bxs-home','bxs-home-circle','bxs-home-heart',
    'bxs-hotel','bxs-hourglass','bxs-id-card','bxs-image','bxs-image-add','bxs-images',
    'bxs-info-circle','bxs-joystick','bxs-key','bxs-label','bxs-landscape','bxs-laugh',
    'bxs-layer','bxs-layout','bxs-left-arrow','bxs-left-arrow-circle','bxs-like',
    'bxs-lock','bxs-lock-alt','bxs-lock-open','bxs-magic-wand','bxs-magnet','bxs-map',
    'bxs-map-alt','bxs-map-pin','bxs-medal','bxs-megaphone','bxs-memory-card','bxs-message',
    'bxs-message-add','bxs-message-alt','bxs-message-alt-dots','bxs-message-check',
    'bxs-message-dots','bxs-microphone','bxs-microphone-off','bxs-minus-circle','bxs-mobile',
    'bxs-moon','bxs-mouse','bxs-movie','bxs-movie-play','bxs-music','bxs-navigation',
    'bxs-network-chart','bxs-news','bxs-no-entry','bxs-note','bxs-notepad','bxs-notification',
    'bxs-offer','bxs-package','bxs-paint','bxs-paint-roll','bxs-palette','bxs-paperclip',
    'bxs-paste','bxs-pause-circle','bxs-pen','bxs-pencil','bxs-phone','bxs-phone-call',
    'bxs-phone-incoming','bxs-photo-album','bxs-pie-chart','bxs-pie-chart-alt-2',
    'bxs-pin','bxs-plane','bxs-planet','bxs-play-circle','bxs-plug','bxs-plus-circle',
    'bxs-pointer','bxs-poll','bxs-printer','bxs-purchase-tag','bxs-purchase-tag-alt',
    'bxs-right-arrow','bxs-right-arrow-circle','bxs-rocket','bxs-sad','bxs-save',
    'bxs-search','bxs-search-alt','bxs-send','bxs-server','bxs-share-alt','bxs-shield',
    'bxs-shield-alt-2','bxs-shield-minus','bxs-shield-plus','bxs-shield-x','bxs-skip-next-circle',
    'bxs-skip-previous-circle','bxs-sleepy','bxs-slider','bxs-slideshow','bxs-smile',
    'bxs-spa','bxs-spreadsheet','bxs-star','bxs-star-half','bxs-station','bxs-stats',
    'bxs-store','bxs-store-alt','bxs-sun','bxs-support','bxs-tag','bxs-tag-alt',
    'bxs-target-lock','bxs-task','bxs-task-x','bxs-time','bxs-timer','bxs-tired',
    'bxs-toggle-left','bxs-toggle-right','bxs-torch','bxs-train','bxs-trash','bxs-trash-alt',
    'bxs-trophy','bxs-tv','bxs-up-arrow','bxs-up-arrow-circle','bxs-upload','bxs-user',
    'bxs-user-badge','bxs-user-check','bxs-user-circle','bxs-user-detail','bxs-user-minus',
    'bxs-user-pin','bxs-user-plus','bxs-user-voice','bxs-user-x','bxs-video','bxs-video-off',
    'bxs-video-plus','bxs-voicemail','bxs-volume','bxs-volume-full','bxs-volume-mute',
    'bxs-wallet','bxs-watch','bxs-water','bxs-webcam','bxs-window-alt','bxs-wink-smile',
    'bxs-wrench','bxs-x-circle','bxs-zoom-in','bxs-zoom-out',
  ];

  var pickerModal = null;

  // ── Render icon grid ────────────────────────────────────────────────
  function renderIconGrid(filter) {
    var grid   = document.getElementById('role-icon-grid');
    var active = document.getElementById('role-icon-input').value;
    grid.innerHTML = '';
    var lower = (filter || '').toLowerCase();
    var shown  = lower ? ICONS.filter(function (ic) { return ic.indexOf(lower) !== -1; }) : ICONS;

    shown.forEach(function (ic) {
      var col = document.createElement('div');
      col.className = 'col-2 col-sm-1';
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.title = ic;
      btn.className = 'btn btn-sm w-100 p-2' + (ic === active ? ' btn-primary' : ' btn-outline-secondary');
      btn.style.cssText = 'aspect-ratio:1;font-size:1.25rem';
      btn.innerHTML = '<i class="bx ' + ic + '"></i>';
      btn.addEventListener('click', function () { selectIcon(ic); });
      col.appendChild(btn);
      grid.appendChild(col);
    });
  }

  function selectIcon(ic) {
    document.getElementById('role-icon-input').value = ic;
    updatePreview();
    if (pickerModal) pickerModal.hide();
  }

  function updatePreview() {
    var ic    = document.getElementById('role-icon-input').value;
    var color = document.getElementById('role-color-picker').value;
    var wrap  = document.getElementById('role-icon-preview');
    wrap.style.background = hexToRgba(color, 0.13);
    wrap.innerHTML = '<i class="bx ' + ic + '" style="color:' + color + '"></i>';
  }

  function hexToRgba(hex, alpha) {
    var r = parseInt(hex.slice(1,3),16);
    var g = parseInt(hex.slice(3,5),16);
    var b = parseInt(hex.slice(5,7),16);
    return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
  }

  // Open picker
  document.getElementById('role-icon-pick-btn').addEventListener('click', function () {
    if (!pickerModal) {
      pickerModal = new bootstrap.Modal(document.getElementById('roleIconPickerModal'));
    }
    document.getElementById('role-icon-search').value = '';
    renderIconGrid('');
    pickerModal.show();
    setTimeout(function () { document.getElementById('role-icon-search').focus(); }, 350);
  });

  document.getElementById('role-icon-search').addEventListener('input', function () {
    renderIconGrid(this.value);
  });

  // Color sync
  var picker = document.getElementById('role-color-picker');
  var hexInp = document.getElementById('role-color-hex');
  picker.addEventListener('input', function () {
    hexInp.value = picker.value;
    updatePreview();
  });
  hexInp.addEventListener('input', function () {
    if (/^#[0-9a-fA-F]{6}$/.test(hexInp.value)) {
      picker.value = hexInp.value;
      updatePreview();
    }
  });

}());
</script>
