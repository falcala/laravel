@php
  $items  = $section->content['items'] ?? [];
  $faqId  = 'faq-' . $section->id;
@endphp

<section class="py-5">
  <div class="container">
    @if(!empty($section->title))
      <h2 class="text-center fw-bold mb-5">{{ $section->title }}</h2>
    @endif

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion" id="{{ $faqId }}">
          @foreach($items as $i => $item)
          @php $collapseId = $faqId . '-item-' . $i; @endphp
          <div class="accordion-item border mb-2 rounded overflow-hidden">
            <h2 class="accordion-header">
              <button class="accordion-button {{ $i !== 0 ? 'collapsed' : '' }} fw-semibold"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#{{ $collapseId }}"
                      aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                {{ $item['question'] ?? '' }}
              </button>
            </h2>
            <div id="{{ $collapseId }}"
                 class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                 data-bs-parent="#{{ $faqId }}">
              <div class="accordion-body text-muted">
                {{ $item['answer'] ?? '' }}
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
