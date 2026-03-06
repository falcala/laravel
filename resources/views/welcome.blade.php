<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  {{-- Primary SEO --}}
  <title>{{ $page->seo_title ?: $page->title }}</title>
  <meta name="description"
        content="{{ $page->seo_description ?: $page->meta_description }}">
  @if($page->seo_keywords)
  <meta name="keywords" content="{{ $page->seo_keywords }}">
  @endif
  @if($page->canonical_url)
  <link rel="canonical" href="{{ $page->canonical_url }}">
  @endif

  {{-- Open Graph --}}
  <meta property="og:type"        content="website">
  <meta property="og:url"         content="{{ $page->canonical_url ?: url('/') }}">
  <meta property="og:title"       content="{{ $page->og_title ?: $page->seo_title ?: $page->title }}">
  <meta property="og:description" content="{{ $page->og_description ?: $page->seo_description ?: $page->meta_description }}">
  @if($page->og_image_url)
  <meta property="og:image"       content="{{ $page->og_image_url }}">
  @endif

  {{-- Twitter / X --}}
  <meta name="twitter:card"  content="{{ $page->twitter_card ?? 'summary_large_image' }}">
  @if($page->twitter_site)
  <meta name="twitter:site"  content="@{{ ltrim($page->twitter_site, '@') }}">
  @endif
  <meta name="twitter:title" content="{{ $page->og_title ?: $page->seo_title ?: $page->title }}">
  <meta name="twitter:description"
        content="{{ $page->og_description ?: $page->seo_description ?: $page->meta_description }}">
  @if($page->og_image_url)
  <meta name="twitter:image" content="{{ $page->og_image_url }}">
  @endif

  {{-- Favicon --}}
  @if($page->favicon_url)
  <link rel="icon" href="{{ $page->favicon_url }}">
  @endif

  {{-- Schema.org JSON-LD --}}
  @if($page->schema_markup)
  <script type="application/ld+json">
    {!! json_encode($page->schema_markup, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
  </script>
  @endif

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <style>
    .hero-slide { min-height: 480px; display:flex; align-items:center; }
    .pricing-card.highlighted { border: 2px solid #696cff; transform: scale(1.05); }
    .feature-icon { width:56px; height:56px; border-radius:12px; display:flex; align-items:center; justify-content:center; background:rgba(105,108,255,.1); }
  </style>
</head>
<body>

  {{-- Navbar --}}
  @php
    $navPos   = $page->nav_position ?? 'normal';
    $navClass = match($navPos) { 'sticky' => 'sticky-top', 'fixed' => 'fixed-top', default => '' };
    $navItems = $page->nav_enabled ? ($page->nav_items ?? []) : [];
  @endphp
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm {{ $navClass }}" id="main-navbar">
    <div class="container">

      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('welcome') }}">
        @if($page->logo_url)
          <img src="{{ $page->logo_url }}" alt="{{ $page->title }}" style="max-height:36px;object-fit:contain">
        @else
          {{ $page->title }}
        @endif
      </a>

      @if(count($navItems))
      <button class="navbar-toggler border-0 ms-auto me-2" type="button"
              data-bs-toggle="collapse" data-bs-target="#main-nav-collapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-nav-collapse">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          @foreach($navItems as $item)
            @if(!empty($item['children']))
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="{{ $item['url'] ?: '#' }}"
                 role="button" data-bs-toggle="dropdown">{{ $item['label'] }}</a>
              <ul class="dropdown-menu">
                @foreach($item['children'] as $child)
                  <li><a class="dropdown-item" href="{{ $child['url'] ?: '#' }}">{{ $child['label'] }}</a></li>
                @endforeach
              </ul>
            </li>
            @else
            <li class="nav-item">
              <a class="nav-link" href="{{ $item['url'] ?: '#' }}">{{ $item['label'] }}</a>
            </li>
            @endif
          @endforeach
        </ul>
      </div>
      @endif

      <div class="{{ count($navItems) ? '' : 'ms-auto' }} d-flex gap-2">
        @auth
          <a href="{{ route('dashboard') }}" class="btn">
            <img src="{{ url('img/icon_login.png') }}" width="35px" alt="Panel de Control" title="Panel de Control">
          </a>
        @else
          <a href="{{ route('login') }}" class="btn btn-sm">
            <img src="{{ url('img/icon_login.png') }}" width="35px" alt="Ingresar" title="Ingresar">
          </a>
          <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
            <img src="{{ url('img/icon_register.png') }}" width="35px" alt="Registrarse" title="Registrarse">
          </a>
        @endauth
      </div>

    </div>
  </nav>
  @if($navPos === 'fixed')<div style="height:56px"></div>@endif

  {{-- Sections --}}
  @foreach($sections as $section)
    <div @if($section->anchor) id="{{ $section->anchor }}" @endif style="scroll-margin-top:64px">
      @if($section->type === 'hero')
        <x-sections.hero :section="$section" />
      @elseif($section->type === 'features')
        <x-sections.features :section="$section" />
      @elseif($section->type === 'pricing')
        <x-sections.pricing :section="$section" />
      @elseif($section->type === 'calendar')
        <x-sections.calendar :section="$section" />
      @elseif($section->type === 'gallery')
        <x-sections.gallery :section="$section" />
      @elseif($section->type === 'testimonial')
        <x-sections.testimonial :section="$section" />
      @elseif($section->type === 'faq')
        <x-sections.faq :section="$section" />
      @elseif($section->type === 'cta')
        <x-sections.cta :section="$section" />
      @elseif($section->type === 'vcard')
        <x-sections.vcard :section="$section" />
      @elseif($section->type === 'custom')
        <x-sections.custom :section="$section" />
      @endif
    </div>
  @endforeach

  {{-- Footer --}}
  <footer class="bg-dark text-white text-center py-4 mt-5">
    <small>&copy; {{ date('Y') }} {{ $page->title }}. All rights reserved.</small>
  </footer>

  {{-- WhatsApp floating button --}}
  @if($page->whatsapp)
  <a href="https://wa.me/{{ $page->whatsapp }}"
     target="_blank" rel="noopener"
     title="Escríbenos por WhatsApp"
     style="position:fixed;bottom:24px;right:24px;z-index:9999;
            width:56px;height:56px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
            transition:transform .2s,box-shadow .2s;text-decoration:none"
     onmouseenter="this.style.transform='scale(1.1)';this.style.boxShadow='0 6px 22px rgba(37,211,102,.6)'"
     onmouseleave="this.style.transform='scale(1)';this.style.boxShadow='none'">
    <img src="{{ url('img/walogo.png') }}" alt="Whatsapp">
  </a>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>