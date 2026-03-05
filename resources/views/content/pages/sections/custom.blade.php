<div class="mb-2">
  <label class="form-label small">Custom HTML</label>
  <textarea name="content[html]" class="form-control form-control-sm font-monospace"
            rows="8">{{ $section->content['html'] ?? '' }}</textarea>
  <small class="text-muted">Raw HTML is rendered directly. Use with care.</small>
</div>