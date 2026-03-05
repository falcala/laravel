@php
$slides      = $section->content['slides']   ?? [];
$settings    = $section->content['settings'] ?? [];
$autoplay    = $settings['autoplay'] ?? true;
$speed       = (int)($settings['speed'] ?? 5000);
$showArrows  = $settings['show_arrows'] ?? true;
$showDots    = $settings['show_dots'] ?? true;
$slideHeight = (int)($settings['height'] ?? 480);
$heroId      = 'hero-'.$section->id;
@endphp

<div id="{{ $heroId }}"
     class="carousel slide"
     data-bs-ride="{{ $autoplay ? 'carousel' : 'false' }}"
     data-bs-interval="{{ $speed }}">

@if($showDots && count($slides)>1)
<div class="carousel-indicators">
@foreach($slides as $i=>$slide)
<button type="button"
        data-bs-target="#{{ $heroId }}"
        data-bs-slide-to="{{ $i }}"
        class="{{ $i==0?'active':'' }}"></button>
@endforeach
</div>
@endif

<div class="carousel-inner">

@foreach($slides as $i=>$slide)

@php
$bgType  = $slide['bg_type'] ?? 'color';
$bgColor = $slide['bg_color'] ?? '#696cff';
$bgImage = $slide['bg_image'] ?? '';

$bgStyle = $bgType==='image'
 ? "background-image:url($bgImage);background-size:cover;background-position:center;"
 : "background-color:$bgColor;";
@endphp

<div class="carousel-item {{ $i==0?'active':'' }}"
     style="height:{{ $slideHeight }}px;{{ $bgStyle }}">

<div class="container h-100 d-flex align-items-center justify-content-center text-center">

<div>

@if(!empty($slide['title']))
<h1 class="fw-bold text-white mb-3">
{{ $slide['title'] }}
</h1>
@endif

@if(!empty($slide['subtitle']))
<p class="text-white mb-4">
{{ $slide['subtitle'] }}
</p>
@endif

@if(!empty($slide['button_text']))
<a href="{{ $slide['button_url'] ?? '#' }}"
   class="btn btn-lg btn-light">
{{ $slide['button_text'] }}
</a>
@endif

</div>

</div>
</div>

@endforeach

</div>

@if($showArrows && count($slides)>1)

<button class="carousel-control-prev"
        type="button"
        data-bs-target="#{{ $heroId }}"
        data-bs-slide="prev">

<span class="carousel-control-prev-icon"></span>

</button>

<button class="carousel-control-next"
        type="button"
        data-bs-target="#{{ $heroId }}"
        data-bs-slide="next">

<span class="carousel-control-next-icon"></span>

</button>

@endif

</div>