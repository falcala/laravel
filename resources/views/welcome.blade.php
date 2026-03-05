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
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
	  <div class="container">
		<a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ route('welcome') }}">
		  @if($page->logo_url)
			<img src="{{ $page->logo_url }}" alt="{{ $page->title }}"
				 style="max-height:36px; object-fit:contain">
		  @else
			{{ $page->title }}
		  @endif
		</a>
		<div class="ms-auto d-flex gap-2">
		  @auth
			<a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">Dashboard</a>
		  @else
			<a href="{{ route('login') }}"    class="btn btn-outline-primary btn-sm">Login</a>
			<a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
		  @endauth
		</div>
	  </div>
	</nav>

  {{-- Sections --}}
	@foreach($sections as $section)

	  @if($section->type === 'hero')
		  <x-sections.hero :section="$section" />

	  @elseif($section->type === 'features')
		  <x-sections.features :section="$section" />

	  @elseif($section->type === 'pricing')
		  <x-sections.pricing :section="$section" />

	  @elseif($section->type === 'calendar')
		  <x-sections.calendar :section="$section" />

	  @elseif($section->type === 'custom')
		  <x-sections.custom :section="$section" />

	  @endif

	@endforeach

  {{-- Footer --}}
  <footer class="bg-dark text-white text-center py-4 mt-5">
    <small>&copy; {{ date('Y') }} {{ $page->title }}. All rights reserved.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>