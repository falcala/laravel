<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <title>{{ $page ? ($page->seo_title ?: $page->title) : $pageOwner->name }}</title>
  @if($page)
  <meta name="description" content="{{ $page->seo_description ?: $page->meta_description }}">
  @if($page->seo_keywords)
  <meta name="keywords" content="{{ $page->seo_keywords }}">
  @endif
  @if($page->canonical_url)
  <link rel="canonical" href="{{ $page->canonical_url }}">
  @endif

  <meta property="og:type"        content="website">
  <meta property="og:title"       content="{{ $page->og_title ?: $page->seo_title ?: $page->title }}">
  <meta property="og:description" content="{{ $page->og_description ?: $page->seo_description ?: $page->meta_description }}">
  @if($page->og_image_url)
  <meta property="og:image" content="{{ $page->og_image_url }}">
  @endif
  <meta name="twitter:card"  content="{{ $page->twitter_card ?? 'summary_large_image' }}">
  <meta name="twitter:title" content="{{ $page->og_title ?: $page->seo_title ?: $page->title }}">
  @if($page->favicon_url)
  <link rel="icon" href="{{ $page->favicon_url }}">
  @endif
  @if($page->schema_markup)
  <script type="application/ld+json">
    {!! json_encode($page->schema_markup, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
  </script>
  @endif
  @endif

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
  <style>
    .hero-slide { min-height: 480px; display:flex; align-items:center; }
    .pricing-card.highlighted { border: 2px solid #696cff; transform: scale(1.05); }
    .feature-icon { width:56px;height:56px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(105,108,255,.1); }
    .fp-navbar-avatar { width:34px;height:34px;object-fit:cover;border-radius:50%;border:2px solid #e7e7ff; }
  </style>
</head>
<body>

  {{-- Draft banner --}}
  @if($isDraft)
  <div class="bg-warning text-dark text-center py-2 small fw-semibold">
    <i class="bx bx-info-circle me-1"></i>
    Esta página aún no está publicada. Solo tú puedes verla.
    <a href="{{ route('frontpages.edit', $pageOwner) }}" class="ms-2 text-dark fw-bold text-decoration-underline">Editar</a>
  </div>
  @endif

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-decoration-none" href="{{ route('frontpages.show', $pageOwner->nickname) }}">
        @if($page && $page->logo_url)
          <img src="{{ $page->logo_url }}" alt="{{ $pageOwner->name }}" style="max-height:36px;object-fit:contain">
        @else
          <img src="{{ $pageOwner->profile_picture_url }}" alt="{{ $pageOwner->name }}" class="fp-navbar-avatar">
          <span>{{ $pageOwner->name }}</span>
          @if($pageOwner->nickname)
            <span class="text-muted fw-normal small">@{{ $pageOwner->nickname }}</span>
          @endif
        @endif
      </a>
      <div class="ms-auto d-flex align-items-center gap-2">
        @auth
          @if(auth()->id() === $pageOwner->id)
            <a href="{{ route('frontpages.edit', $pageOwner) }}" class="btn btn-sm btn-outline-primary">
              <i class="bx bx-edit me-1"></i>Editar
            </a>
          @elseif(auth()->user()->can('frontpages.manage'))
            <a href="{{ route('frontpages.edit', $pageOwner) }}" class="btn btn-sm btn-outline-secondary">
              <i class="bx bx-edit me-1"></i>Editar (admin)
            </a>
          @endif
          <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-tachometer"></i>
          </a>
        @else
          <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-log-in me-1"></i>Ingresar
          </a>
        @endauth
      </div>
    </div>
  </nav>

  {{-- Sections --}}
  @if($page && $sections->isNotEmpty())
    @foreach($sections as $section)
      <div @if($section->anchor) id="{{ $section->anchor }}" @endif style="scroll-margin-top:64px">
        @if($section->type === 'hero')         <x-sections.hero :section="$section" />
        @elseif($section->type === 'features') <x-sections.features :section="$section" />
        @elseif($section->type === 'pricing')  <x-sections.pricing :section="$section" />
        @elseif($section->type === 'calendar') <x-sections.calendar :section="$section" />
        @elseif($section->type === 'gallery')  <x-sections.gallery :section="$section" />
        @elseif($section->type === 'testimonial') <x-sections.testimonial :section="$section" />
        @elseif($section->type === 'faq')      <x-sections.faq :section="$section" />
        @elseif($section->type === 'cta')      <x-sections.cta :section="$section" />
        @elseif($section->type === 'vcard')    <x-sections.vcard :section="$section" />
        @elseif($section->type === 'custom')   <x-sections.custom :section="$section" />
        @endif
      </div>
    @endforeach
  @else
    <div class="container py-5 text-center text-muted">
      <i class="bx bx-layout fs-1 d-block mb-3"></i>
      <h4>Esta página aún no tiene contenido.</h4>
      @auth
        @if(auth()->id() === $pageOwner->id)
          <a href="{{ route('frontpages.edit', $pageOwner) }}" class="btn btn-primary mt-3">
            <i class="bx bx-plus me-1"></i>Agregar secciones
          </a>
        @endif
      @endauth
    </div>
  @endif

  {{-- Footer --}}
  <footer class="bg-dark text-white text-center py-4 mt-5">
    <small>&copy; {{ date('Y') }} {{ $pageOwner->name }}. Todos los derechos reservados.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
