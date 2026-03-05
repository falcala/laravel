<div class="row g-2">
  <div class="col-12">
    <label class="form-label small">Section Subtitle</label>
    <input type="text" name="content[subtitle]" class="form-control form-control-sm"
           value="{{ $section->content['subtitle'] ?? '' }}" />
  </div>
</div>
<small class="text-muted d-block mt-2">
  <i class="bx bx-info-circle"></i>
  The calendar will display upcoming public events automatically.
</small>