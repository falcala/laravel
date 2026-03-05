<?php
  $slides   = $section->content['slides']   ?? [];
  $settings = $section->content['settings'] ?? [];

  // Defaults
  $autoplay    = $settings['autoplay']    ?? true;
  $speed       = $settings['speed']       ?? 5000;
  $showArrows  = $settings['show_arrows'] ?? true;
  $showDots    = $settings['show_dots']   ?? true;
  $slideHeight = $settings['height']      ?? 480;
?>


<div class="card border mb-4">
  <div class="card-header py-2 bg-light">
    <strong><i class="bx bx-cog me-1"></i> Slider Settings</strong>
  </div>
  <div class="card-body">
    <div class="row g-3">

      
      <div class="col-md-3 d-flex align-items-center">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox"
                 name="content[settings][autoplay]" value="1"
                 id="autoplay_<?php echo e($section->id); ?>"
                 <?php echo e($autoplay ? 'checked' : ''); ?>>
          <label class="form-check-label" for="autoplay_<?php echo e($section->id); ?>">Autoplay</label>
        </div>
      </div>

      
      <div class="col-md-3">
        <label class="form-label small mb-1">
          Speed (ms) <span class="text-muted" id="speed-val-<?php echo e($section->id); ?>"><?php echo e($speed); ?></span>
        </label>
        <input type="range" name="content[settings][speed]"
               class="form-range"
               min="1000" max="10000" step="500"
               value="<?php echo e($speed); ?>"
               oninput="document.getElementById('speed-val-<?php echo e($section->id); ?>').textContent=this.value">
      </div>

      
      <div class="col-md-3">
        <label class="form-label small mb-1">
          Height (px) <span class="text-muted" id="height-val-<?php echo e($section->id); ?>"><?php echo e($slideHeight); ?></span>
        </label>
        <input type="range" name="content[settings][height]"
               class="form-range"
               min="200" max="900" step="20"
               value="<?php echo e($slideHeight); ?>"
               oninput="document.getElementById('height-val-<?php echo e($section->id); ?>').textContent=this.value">
      </div>

      
      <div class="col-md-3 d-flex flex-column gap-1 justify-content-center">
        <div class="form-check">
          <input class="form-check-input" type="checkbox"
                 name="content[settings][show_arrows]" value="1"
                 id="arrows_<?php echo e($section->id); ?>"
                 <?php echo e($showArrows ? 'checked' : ''); ?>>
          <label class="form-check-label small" for="arrows_<?php echo e($section->id); ?>">Show Arrows</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox"
                 name="content[settings][show_dots]" value="1"
                 id="dots_<?php echo e($section->id); ?>"
                 <?php echo e($showDots ? 'checked' : ''); ?>>
          <label class="form-check-label small" for="dots_<?php echo e($section->id); ?>">Show Dots</label>
        </div>
      </div>

    </div>
  </div>
</div>


<div id="hero-slides-<?php echo e($section->id); ?>">
<?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
  $titlePos  = $slide['title_position']  ?? 'center';
  $titleSize = $slide['title_size']      ?? '3';
  $titleWeight = $slide['title_weight']  ?? '700';
  $titleColor  = $slide['title_color']   ?? '#ffffff';
  $subPos    = $slide['subtitle_position'] ?? 'center';
  $subSize   = $slide['subtitle_size']     ?? '1.25';
  $subColor  = $slide['subtitle_color']    ?? '#ffffff';
  $overlayOpacity = $slide['overlay_opacity'] ?? '40';
  $bgType    = $slide['bg_type'] ?? 'color';
?>
<div class="border rounded mb-3 slide-item" data-index="<?php echo e($i); ?>">

  
  <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-light border-bottom rounded-top">
    <strong class="small">Slide <?php echo e($i + 1); ?></strong>
    <button type="button" class="btn btn-sm btn-outline-danger remove-slide">
      <i class="bx bx-trash"></i> Remove
    </button>
  </div>

  <div class="p-3">
    <div class="row g-3">

      
      <div class="col-12">
        <label class="form-label small fw-semibold">Background</label>
        <div class="d-flex gap-3 mb-2">
          <div class="form-check">
            <input class="form-check-input bg-type-radio" type="radio"
                   name="content[slides][<?php echo e($i); ?>][bg_type]"
                   value="color" id="bgc_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
                   data-slide="<?php echo e($section->id); ?>_<?php echo e($i); ?>"
                   <?php echo e($bgType === 'color' ? 'checked' : ''); ?>>
            <label class="form-check-label small" for="bgc_<?php echo e($section->id); ?>_<?php echo e($i); ?>">Color</label>
          </div>
          <div class="form-check">
            <input class="form-check-input bg-type-radio" type="radio"
                   name="content[slides][<?php echo e($i); ?>][bg_type]"
                   value="image" id="bgi_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
                   data-slide="<?php echo e($section->id); ?>_<?php echo e($i); ?>"
                   <?php echo e($bgType === 'image' ? 'checked' : ''); ?>>
            <label class="form-check-label small" for="bgi_<?php echo e($section->id); ?>_<?php echo e($i); ?>">Image URL</label>
          </div>
        </div>

        
        <div class="bg-color-field" id="bgcolor_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
             style="<?php echo e($bgType !== 'color' ? 'display:none' : ''); ?>">
          <div class="d-flex gap-2 align-items-center">
            <input type="color"
                   name="content[slides][<?php echo e($i); ?>][bg_color]"
                   class="form-control form-control-color"
                   value="<?php echo e($slide['bg_color'] ?? '#696cff'); ?>"
                   style="width:46px;height:38px">
            <input type="text"
                   name="content[slides][<?php echo e($i); ?>][bg_color_hex]"
                   class="form-control form-control-sm"
                   value="<?php echo e($slide['bg_color'] ?? '#696cff'); ?>"
                   placeholder="#696cff">
          </div>
        </div>

        
		<div class="bg-image-field" id="bgimage_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
			 style="<?php echo e($bgType !== 'image' ? 'display:none' : ''); ?>">

		  
		  <?php if(!empty($slide['bg_image'])): ?>
		  <div class="mb-2">
			<img src="<?php echo e($slide['bg_image']); ?>"
				 id="preview_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
				 class="img-fluid rounded"
				 style="max-height:120px; object-fit:cover; width:100%">
		  </div>
		  <?php else: ?>
		  <div class="mb-2" id="preview_wrap_<?php echo e($section->id); ?>_<?php echo e($i); ?>" style="display:none">
			<img src="" id="preview_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
				 class="img-fluid rounded"
				 style="max-height:120px; object-fit:cover; width:100%">
		  </div>
		  <?php endif; ?>

		  
		  <div class="input-group input-group-sm mb-2">
			<span class="input-group-text"><i class="bx bx-link"></i></span>
			<input type="text"
				   name="content[slides][<?php echo e($i); ?>][bg_image]"
				   id="bg_image_url_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
				   class="form-control"
				   value="<?php echo e($slide['bg_image'] ?? ''); ?>"
				   placeholder="https://... or upload below">
		  </div>

		  
		  <div class="d-flex align-items-center gap-2">
			<label class="btn btn-outline-secondary btn-sm mb-0" style="cursor:pointer">
			  <i class="bx bx-upload me-1"></i> Upload Image
			  <input type="file"
					 accept="image/jpeg,image/png,image/webp,image/gif"
					 class="slide-image-upload d-none"
					 data-section="<?php echo e($section->id); ?>"
					 data-index="<?php echo e($i); ?>"
					 data-url-field="bg_image_url_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
					 data-preview="preview_<?php echo e($section->id); ?>_<?php echo e($i); ?>"
					 data-preview-wrap="preview_wrap_<?php echo e($section->id); ?>_<?php echo e($i); ?>">
			</label>
			<span class="upload-status-<?php echo e($section->id); ?>-<?php echo e($i); ?> text-muted small"></span>
		  </div>

		  
		  <div class="mt-2">
			<label class="form-label small">
			  Overlay Opacity:
			  <span id="ov-val-<?php echo e($section->id); ?>-<?php echo e($i); ?>"><?php echo e($overlayOpacity); ?>%</span>
			</label>
			<input type="range"
				   name="content[slides][<?php echo e($i); ?>][overlay_opacity]"
				   class="form-range"
				   min="0" max="90" step="5"
				   value="<?php echo e($overlayOpacity); ?>"
				   oninput="document.getElementById('ov-val-<?php echo e($section->id); ?>-<?php echo e($i); ?>').textContent=this.value+'%'">
		  </div>
		</div>

      </div>

      
      <div class="col-md-6">
        <label class="form-label small">Title</label>
        <input type="text"
               name="content[slides][<?php echo e($i); ?>][title]"
               class="form-control form-control-sm"
               value="<?php echo e($slide['title'] ?? ''); ?>" />
      </div>
      <div class="col-md-6">
        <label class="form-label small">Subtitle</label>
        <input type="text"
               name="content[slides][<?php echo e($i); ?>][subtitle]"
               class="form-control form-control-sm"
               value="<?php echo e($slide['subtitle'] ?? ''); ?>" />
      </div>

      
      <div class="col-12">
        <div class="border rounded p-2 bg-light">
          <small class="fw-semibold d-block mb-2">Title Typography</small>
          <div class="row g-2">
            <div class="col-md-3">
              <label class="form-label small mb-1">Alignment</label>
              <select name="content[slides][<?php echo e($i); ?>][title_position]" class="form-select form-select-sm">
                <?php $__currentLoopData = ['left'=>'Left','center'=>'Center','right'=>'Right']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($val); ?>" <?php echo e($titlePos === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small mb-1">Size (rem)</label>
              <select name="content[slides][<?php echo e($i); ?>][title_size]" class="form-select form-select-sm">
                <?php $__currentLoopData = ['1.5'=>'1.5','2'=>'2','2.5'=>'2.5','3'=>'3','3.5'=>'3.5','4'=>'4','5'=>'5']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($val); ?>" <?php echo e($titleSize === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small mb-1">Weight</label>
              <select name="content[slides][<?php echo e($i); ?>][title_weight]" class="form-select form-select-sm">
                <?php $__currentLoopData = ['400'=>'Normal','500'=>'Medium','600'=>'Semibold','700'=>'Bold','800'=>'Extrabold']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($val); ?>" <?php echo e($titleWeight === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small mb-1">Color</label>
              <div class="d-flex gap-1">
                <input type="color"
                       name="content[slides][<?php echo e($i); ?>][title_color]"
                       class="form-control form-control-color"
                       value="<?php echo e($titleColor); ?>"
                       style="width:38px;height:31px">
                <input type="text"
                       name="content[slides][<?php echo e($i); ?>][title_color_hex]"
                       class="form-control form-control-sm"
                       value="<?php echo e($titleColor); ?>">
              </div>
            </div>
          </div>
        </div>
      </div>

      
      <div class="col-12">
        <div class="border rounded p-2 bg-light">
          <small class="fw-semibold d-block mb-2">Subtitle Typography</small>
          <div class="row g-2">
            <div class="col-md-3">
              <label class="form-label small mb-1">Alignment</label>
              <select name="content[slides][<?php echo e($i); ?>][subtitle_position]" class="form-select form-select-sm">
                <?php $__currentLoopData = ['left'=>'Left','center'=>'Center','right'=>'Right']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($val); ?>" <?php echo e($subPos === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small mb-1">Size (rem)</label>
              <select name="content[slides][<?php echo e($i); ?>][subtitle_size]" class="form-select form-select-sm">
                <?php $__currentLoopData = ['0.875'=>'0.875','1'=>'1','1.125'=>'1.125','1.25'=>'1.25','1.5'=>'1.5','1.75'=>'1.75','2'=>'2']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($val); ?>" <?php echo e($subSize === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small mb-1">Weight</label>
              <select name="content[slides][<?php echo e($i); ?>][subtitle_weight]" class="form-select form-select-sm">
                <?php $__currentLoopData = ['300'=>'Light','400'=>'Normal','500'=>'Medium','600'=>'Semibold','700'=>'Bold']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($val); ?>" <?php echo e(($slide['subtitle_weight'] ?? '400') === $val ? 'selected' : ''); ?>><?php echo e($lbl); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small mb-1">Color</label>
              <div class="d-flex gap-1">
                <input type="color"
                       name="content[slides][<?php echo e($i); ?>][subtitle_color]"
                       class="form-control form-control-color"
                       value="<?php echo e($subColor); ?>"
                       style="width:38px;height:31px">
                <input type="text"
                       name="content[slides][<?php echo e($i); ?>][subtitle_color_hex]"
                       class="form-control form-control-sm"
                       value="<?php echo e($subColor); ?>">
              </div>
            </div>
          </div>
        </div>
      </div>

      
      <div class="col-12">
        <div class="border rounded p-2 bg-light">
          <small class="fw-semibold d-block mb-2">Button</small>
          <div class="row g-2">

            <div class="col-md-6">
              <label class="form-label small">Text</label>
              <input type="text"
                     name="content[slides][<?php echo e($i); ?>][button_text]"
                     class="form-control form-control-sm"
                     value="<?php echo e($slide['button_text'] ?? ''); ?>"
                     placeholder="Get Started" />
            </div>

            <div class="col-md-6">
              <label class="form-label small">URL</label>
              <input type="text"
                     name="content[slides][<?php echo e($i); ?>][button_url]"
                     class="form-control form-control-sm"
                     value="<?php echo e($slide['button_url'] ?? '#'); ?>" />
            </div>

            <div class="col-md-4">
              <label class="form-label small">Alignment</label>
              <select name="content[slides][<?php echo e($i); ?>][button_align]"
                      class="form-select form-select-sm">
                <?php $__currentLoopData = ['left' => 'Left', 'center' => 'Center', 'right' => 'Right']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($val); ?>"
                    <?php echo e(($slide['button_align'] ?? 'center') === $val ? 'selected' : ''); ?>>
                    <?php echo e($lbl); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label small">Background</label>
              <div class="d-flex gap-1">
                <input type="color"
                       name="content[slides][<?php echo e($i); ?>][button_bg]"
                       class="form-control form-control-color"
                       value="<?php echo e($slide['button_bg'] ?? '#ffffff'); ?>"
                       style="width:38px;height:31px">
                <input type="text"
                       name="content[slides][<?php echo e($i); ?>][button_bg_hex]"
                       class="form-control form-control-sm"
                       value="<?php echo e($slide['button_bg'] ?? '#ffffff'); ?>">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label small">Font Color</label>
              <div class="d-flex gap-1">
                <input type="color"
                       name="content[slides][<?php echo e($i); ?>][button_color]"
                       class="form-control form-control-color"
                       value="<?php echo e($slide['button_color'] ?? '#696cff'); ?>"
                       style="width:38px;height:31px">
                <input type="text"
                       name="content[slides][<?php echo e($i); ?>][button_color_hex]"
                       class="form-control form-control-sm"
                       value="<?php echo e($slide['button_color'] ?? '#696cff'); ?>">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label small">Hover Background</label>
              <div class="d-flex gap-1">
                <input type="color"
                       name="content[slides][<?php echo e($i); ?>][button_hover_bg]"
                       class="form-control form-control-color"
                       value="<?php echo e($slide['button_hover_bg'] ?? '#f0f0f0'); ?>"
                       style="width:38px;height:31px">
                <input type="text"
                       name="content[slides][<?php echo e($i); ?>][button_hover_bg_hex]"
                       class="form-control form-control-sm"
                       value="<?php echo e($slide['button_hover_bg'] ?? '#f0f0f0'); ?>">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label small">Hover Font Color</label>
              <div class="d-flex gap-1">
                <input type="color"
                       name="content[slides][<?php echo e($i); ?>][button_hover_color]"
                       class="form-control form-control-color"
                       value="<?php echo e($slide['button_hover_color'] ?? '#333333'); ?>"
                       style="width:38px;height:31px">
                <input type="text"
                       name="content[slides][<?php echo e($i); ?>][button_hover_color_hex]"
                       class="form-control form-control-sm"
                       value="<?php echo e($slide['button_hover_color'] ?? '#333333'); ?>">
              </div>
            </div>

            
            <div class="col-12">
              <label class="form-label small">Preview</label>
              <div data-btn-preview="<?php echo e($section->id); ?>-<?php echo e($i); ?>"
                   style="text-align:<?php echo e($slide['button_align'] ?? 'center'); ?>">
                <button type="button"
                        data-btn-el="<?php echo e($section->id); ?>-<?php echo e($i); ?>"
                        class="btn btn-sm px-4 py-2"
                        style="
                          background-color:<?php echo e($slide['button_bg'] ?? '#ffffff'); ?>;
                          color:<?php echo e($slide['button_color'] ?? '#696cff'); ?>;
                          border:none;
                          transition:background-color .2s,color .2s;
                        ">
                  <?php echo e($slide['button_text'] ?? 'Button'); ?>

                </button>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<button type="button"
        class="btn btn-outline-primary btn-sm w-100 mt-2 add-slide-btn"
        data-section="<?php echo e($section->id); ?>">
  <i class="bx bx-plus me-1"></i> Add Slide
</button>


<script>
(function () {
  var sectionId = '<?php echo e($section->id); ?>';
  var count     = <?php echo e(count($slides)); ?>;

  // Background type toggle (existing slides)
  function initBgToggle(slideKey) {
    var radios = document.querySelectorAll(
      'input.bg-type-radio[data-slide="' + slideKey + '"]'
    );
    radios.forEach(function (r) {
      r.addEventListener('change', function () {
        document.getElementById('bgcolor_' + slideKey).style.display =
          r.value === 'color' ? '' : 'none';
        document.getElementById('bgimage_' + slideKey).style.display =
          r.value === 'image' ? '' : 'none';
      });
    });
  }

  // Init existing slides
  <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  initBgToggle(sectionId + '_<?php echo e($i); ?>');
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  // Remove slide
  function bindRemove() {
    document.querySelectorAll(
      '#hero-slides-' + sectionId + ' .remove-slide'
    ).forEach(function (btn) {
      btn.onclick = function () {
        if (document.querySelectorAll(
          '#hero-slides-' + sectionId + ' .slide-item'
        ).length > 1) {
          btn.closest('.slide-item').remove();
        } else {
          alert('A slider must have at least one slide.');
        }
      };
    });
  }
  bindRemove();

  // Add slide button
  document.querySelectorAll('.add-slide-btn[data-section="' + sectionId + '"]')
    .forEach(function (btn) {
      btn.addEventListener('click', function () {
        var idx = count;
        var slideKey = sectionId + '_' + idx;
        var tpl = `	<div class="col-12">
        <div class="border rounded p-2 bg-light">
          <small class="fw-semibold d-block mb-2">Button</small>
          <div class="row g-2">
            <div class="col-md-6">
              <label class="form-label small">Text</label>
              <input type="text" name="content[slides][${idx}][button_text]"
                     class="form-control form-control-sm" placeholder="Get Started">
            </div>
            <div class="col-md-6">
              <label class="form-label small">URL</label>
              <input type="text" name="content[slides][${idx}][button_url]"
                     class="form-control form-control-sm" value="#">
            </div>
            <div class="col-md-4">
              <label class="form-label small">Alignment</label>
              <select name="content[slides][${idx}][button_align]" class="form-select form-select-sm">
                <option value="left">Left</option>
                <option value="center" selected>Center</option>
                <option value="right">Right</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Background</label>
              <div class="d-flex gap-1">
                <input type="color" name="content[slides][${idx}][button_bg]"
                       class="form-control form-control-color" value="#ffffff" style="width:38px;height:31px">
                <input type="text" name="content[slides][${idx}][button_bg_hex]"
                       class="form-control form-control-sm" value="#ffffff">
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Font Color</label>
              <div class="d-flex gap-1">
                <input type="color" name="content[slides][${idx}][button_color]"
                       class="form-control form-control-color" value="#696cff" style="width:38px;height:31px">
                <input type="text" name="content[slides][${idx}][button_color_hex]"
                       class="form-control form-control-sm" value="#696cff">
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Hover Background</label>
              <div class="d-flex gap-1">
                <input type="color" name="content[slides][${idx}][button_hover_bg]"
                       class="form-control form-control-color" value="#f0f0f0" style="width:38px;height:31px">
                <input type="text" name="content[slides][${idx}][button_hover_bg_hex]"
                       class="form-control form-control-sm" value="#f0f0f0">
              </div>
            </div>
            <div class="col-md-4">
              <label class="form-label small">Hover Font Color</label>
              <div class="d-flex gap-1">
                <input type="color" name="content[slides][${idx}][button_hover_color]"
                       class="form-control form-control-color" value="#333333" style="width:38px;height:31px">
                <input type="text" name="content[slides][${idx}][button_hover_color_hex]"
                       class="form-control form-control-sm" value="#333333">
              </div>
            </div>
            <div class="col-12">
              <label class="form-label small">Preview</label>
              <div data-btn-preview="${sectionId}-${idx}" style="text-align:center">
                <button type="button" data-btn-el="${sectionId}-${idx}"
                        class="btn btn-sm px-4 py-2"
                        style="background-color:#ffffff;color:#696cff;border:none;transition:background-color .2s,color .2s;">
                  Button
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>`;
        document.getElementById('hero-slides-' + sectionId)
          .insertAdjacentHTML('beforeend', tpl);
        count++;
        initBgToggle(slideKey);
        bindRemove();
      });
    });
}());
</script>
<script>
(function () {
  var uploadUrl  = '<?php echo e(route('pages.sections.upload-slide-image')); ?>';
  var csrfToken  = '<?php echo e(csrf_token()); ?>';

  function initUpload() {
    document.querySelectorAll('.slide-image-upload').forEach(function (input) {
      if (input.dataset.uploadBound) return; // prevent double binding
      input.dataset.uploadBound = '1';

      input.addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;

        var file         = this.files[0];
        var urlFieldId   = this.dataset.urlField;
        var previewId    = this.dataset.preview;
        var previewWrapId= this.dataset.previewWrap;
        var sectionId    = this.dataset.section;
        var index        = this.dataset.index;
        var statusEl     = document.querySelector('.upload-status-' + sectionId + '-' + index);

        // Validate size client-side (4MB)
        if (file.size > 4 * 1024 * 1024) {
          statusEl.textContent = '✗ Max 4MB allowed.';
          statusEl.className = 'upload-status-' + sectionId + '-' + index + ' text-danger small';
          return;
        }

        statusEl.textContent = 'Uploading…';
        statusEl.className   = 'upload-status-' + sectionId + '-' + index + ' text-muted small';

        var fd = new FormData();
        fd.append('image', file);
        fd.append('_token', csrfToken);

        fetch(uploadUrl, { method: 'POST', body: fd })
          .then(function (r) { return r.json(); })
          .then(function (data) {
            if (data.success) {
              // Put URL into the text field
              var urlField = document.getElementById(urlFieldId);
              if (urlField) urlField.value = data.url;

              // Show preview
              var preview = document.getElementById(previewId);
              if (preview) {
                preview.src = data.url;
                preview.style.display = '';
              }
              var wrap = document.getElementById(previewWrapId);
              if (wrap) wrap.style.display = '';

              statusEl.textContent = '✓ Uploaded successfully';
              statusEl.className   = 'upload-status-' + sectionId + '-' + index + ' text-success small';
            } else {
              statusEl.textContent = '✗ Upload failed.';
              statusEl.className   = 'upload-status-' + sectionId + '-' + index + ' text-danger small';
            }
          })
          .catch(function () {
            statusEl.textContent = '✗ Network error.';
            statusEl.className   = 'upload-status-' + sectionId + '-' + index + ' text-danger small';
          });
      });
    });
  }

  // Init on load and re-init when new slides are added
  initUpload();

  // Re-init after add-slide button click
  document.querySelectorAll('.add-slide-btn[data-section="<?php echo e($section->id); ?>"]')
    .forEach(function (btn) {
      btn.addEventListener('click', function () {
        setTimeout(initUpload, 100);
      });
    });
}());
</script>
<script>
(function () {
  function initButtonPreviews() {
    // Sync color pickers with hex text fields
    document.querySelectorAll('.slide-item').forEach(function (slide) {
      var idx       = slide.dataset.index;
      var secId     = '<?php echo e($section->id); ?>';
      var btnEl     = document.querySelector('[data-btn-el="' + secId + '-' + idx + '"]');
      var btnWrap   = document.querySelector('[data-btn-preview="' + secId + '-' + idx + '"]');
      if (!btnEl) return;

      function getField(name) {
        return slide.querySelector('input[name="content[slides][' + idx + '][' + name + ']"]');
      }

      var fields = {
        button_text        : getField('button_text'),
        button_bg          : getField('button_bg'),
        button_bg_hex      : getField('button_bg_hex'),
        button_color       : getField('button_color'),
        button_color_hex   : getField('button_color_hex'),
        button_hover_bg    : getField('button_hover_bg'),
        button_hover_bg_hex: getField('button_hover_bg_hex'),
        button_hover_color : getField('button_hover_color'),
        button_hover_color_hex: getField('button_hover_color_hex'),
        button_align       : slide.querySelector('select[name="content[slides][' + idx + '][button_align]"]'),
      };

      function updatePreview() {
        if (!btnEl) return;
        var bg    = fields.button_bg_hex    ? fields.button_bg_hex.value    : '#ffffff';
        var color = fields.button_color_hex ? fields.button_color_hex.value : '#696cff';
        var text  = fields.button_text      ? fields.button_text.value      : 'Button';
        var align = fields.button_align     ? fields.button_align.value     : 'center';

        btnEl.style.backgroundColor = bg;
        btnEl.style.color           = color;
        btnEl.textContent           = text || 'Button';
        if (btnWrap) btnWrap.style.textAlign = align;

        // Store hover values on element for mouseenter/leave
        btnEl.dataset.hoverBg    = fields.button_hover_bg_hex    ? fields.button_hover_bg_hex.value    : '#f0f0f0';
        btnEl.dataset.hoverColor = fields.button_hover_color_hex ? fields.button_hover_color_hex.value : '#333333';
        btnEl.dataset.normalBg   = bg;
        btnEl.dataset.normalColor= color;
      }

      // Sync color picker → hex text
      function syncPair(pickerField, hexField) {
        if (!pickerField || !hexField) return;
        pickerField.addEventListener('input', function () {
          hexField.value = pickerField.value;
          updatePreview();
        });
        hexField.addEventListener('input', function () {
          if (/^#[0-9a-fA-F]{6}$/.test(hexField.value)) {
            pickerField.value = hexField.value;
          }
          updatePreview();
        });
      }

      syncPair(fields.button_bg,           fields.button_bg_hex);
      syncPair(fields.button_color,        fields.button_color_hex);
      syncPair(fields.button_hover_bg,     fields.button_hover_bg_hex);
      syncPair(fields.button_hover_color,  fields.button_hover_color_hex);

      if (fields.button_text)  fields.button_text.addEventListener('input', updatePreview);
      if (fields.button_align) fields.button_align.addEventListener('change', updatePreview);

      // Hover effect on preview button
      btnEl.addEventListener('mouseenter', function () {
        this.style.backgroundColor = this.dataset.hoverBg    || '#f0f0f0';
        this.style.color           = this.dataset.hoverColor || '#333333';
      });
      btnEl.addEventListener('mouseleave', function () {
        this.style.backgroundColor = this.dataset.normalBg    || '#ffffff';
        this.style.color           = this.dataset.normalColor || '#696cff';
      });

      updatePreview();
    });
  }

  // Init on load
  initButtonPreviews();

  // Re-init after new slide is added
  document.querySelectorAll('.add-slide-btn[data-section="<?php echo e($section->id); ?>"]')
    .forEach(function (btn) {
      btn.addEventListener('click', function () {
        setTimeout(initButtonPreviews, 150);
      });
    });
}());
</script><?php /**PATH C:\xampp\htdocs\sneat\resources\views/content/pages/sections/hero.blade.php ENDPATH**/ ?>