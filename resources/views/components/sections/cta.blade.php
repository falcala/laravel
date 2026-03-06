@php
  $c = $section->content ?? [];
  $bgColor      = $c['bg_color']          ?? '#696cff';
  $textColor    = $c['text_color']         ?? '#ffffff';
  $btnBg        = $c['button_bg']          ?? '#ffffff';
  $btnColor     = $c['button_color']       ?? '#696cff';
  $btnHoverBg   = $c['button_hover_bg']    ?? '#f0f0f0';
  $btnHoverColor= $c['button_hover_color'] ?? '#333333';
  $align        = $c['align']              ?? 'center';
@endphp

<section style="background-color:{{ $bgColor }};color:{{ $textColor }}">
  <div class="container py-5">
    <div class="text-{{ $align }}">

      @if(!empty($c['heading']))
        <h2 class="fw-bold mb-3" style="color:{{ $textColor }}">{{ $c['heading'] }}</h2>
      @endif

      @if(!empty($c['subheading']))
        <p class="mb-4" style="color:{{ $textColor }};font-size:1.1rem;opacity:.9">{{ $c['subheading'] }}</p>
      @endif

      @if(!empty($c['button_text']) && !empty($c['button_url']))
        <a href="{{ $c['button_url'] }}"
           class="btn btn-lg px-5"
           style="background-color:{{ $btnBg }};color:{{ $btnColor }};border:none;transition:background-color .2s,color .2s"
           onmouseover="this.style.backgroundColor='{{ $btnHoverBg }}';this.style.color='{{ $btnHoverColor }}'"
           onmouseout="this.style.backgroundColor='{{ $btnBg }}';this.style.color='{{ $btnColor }}'">
          {{ $c['button_text'] }}
        </a>
      @endif

    </div>
  </div>
</section>
