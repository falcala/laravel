@php
  $items   = $section->content['items']   ?? [];
  $columns = $section->content['columns'] ?? 3;
  $colClass = ['2' => 'col-md-6', '3' => 'col-md-4', '4' => 'col-md-3'][$columns] ?? 'col-md-4';
@endphp

<section class="py-5 bg-light">
  <div class="container">
    @if(!empty($section->title))
      <h2 class="text-center fw-bold mb-4">{{ $section->title }}</h2>
    @endif

    <div class="row g-3">
      @foreach($items as $item)
        @if(!empty($item['image']))
        <div class="{{ $colClass }} col-6">
          <div class="overflow-hidden rounded shadow-sm position-relative gallery-thumb"
               style="aspect-ratio:4/3">
            <img src="{{ $item['image'] }}"
                 alt="{{ $item['caption'] ?? '' }}"
                 class="w-100 h-100"
                 style="object-fit:cover;transition:transform .3s"
                 onmouseover="this.style.transform='scale(1.05)'"
                 onmouseout="this.style.transform='scale(1)'">
            @if(!empty($item['caption']))
              <div class="position-absolute bottom-0 start-0 end-0 px-2 py-1"
                   style="background:rgba(0,0,0,.45);color:#fff;font-size:.8rem">
                {{ $item['caption'] }}
              </div>
            @endif
          </div>
        </div>
        @endif
      @endforeach
    </div>
  </div>
</section>