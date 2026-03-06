@php
  $items   = $section->content['items']   ?? [];
  $columns = (int)($section->content['columns'] ?? 3);
  $colMap  = [2 => 'col-md-6', 3 => 'col-md-4', 4 => 'col-md-3'];
  $colClass= $colMap[$columns] ?? 'col-md-4';
@endphp

<section class="py-5 bg-light">
  <div class="container">
    @if(!empty($section->title))
      <h2 class="text-center fw-bold mb-5">{{ $section->title }}</h2>
    @endif

    <div class="row g-4 justify-content-center">
      @foreach($items as $item)
      <div class="{{ $colClass }}">
        <div class="card h-100 border-0 shadow-sm p-4">

          {{-- Stars --}}
          @php $rating = (int)($item['rating'] ?? 5); @endphp
          <div class="mb-3">
            @for($s = 1; $s <= 5; $s++)
              <i class="bx {{ $s <= $rating ? 'bxs-star' : 'bx-star' }}"
                 style="color:{{ $s <= $rating ? '#ffc107' : '#d9dee3' }};font-size:1.1rem"></i>
            @endfor
          </div>

          {{-- Text --}}
          <p class="mb-4 text-muted fst-italic">"{{ $item['text'] ?? '' }}"</p>

          {{-- Author --}}
          <div class="d-flex align-items-center gap-3 mt-auto">
            @if(!empty($item['avatar']))
              <img src="{{ $item['avatar'] }}"
                   alt="{{ $item['name'] ?? '' }}"
                   class="rounded-circle"
                   style="width:44px;height:44px;object-fit:cover">
            @else
              <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                   style="width:44px;height:44px;background:#696cff;font-size:1rem;flex-shrink:0">
                {{ strtoupper(substr($item['name'] ?? 'U', 0, 1)) }}
              </div>
            @endif
            <div>
              <div class="fw-semibold small">{{ $item['name'] ?? '' }}</div>
              <div class="text-muted" style="font-size:.8rem">{{ $item['role'] ?? '' }}</div>
            </div>
          </div>

        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
