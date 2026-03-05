@php
	$items = $section->content['items'] ?? [];
	$cols  = 12 / ($section->content['columns'] ?? 3);
@endphp
<section class="py-5">
	<div class="container">
		<h2 class="text-center fw-bold mb-5">{{ $section->title }}</h2>
		<div class="row g-4">
		@foreach($items as $item)
		<div class="col-md-{{ $cols }}">
			<div class="text-center p-4 h-100 border rounded shadow-sm">
				<div class="feature-icon mx-auto mb-3">
					<i class="bx {{ $item['icon'] ?? 'bx-star' }} fs-2 text-primary"></i>
				</div>
				<h5 class="fw-bold">{{ $item['title'] ?? '' }}</h5>
				<p class="text-muted mb-0">{{ $item['description'] ?? '' }}</p>
			</div>
		</div>
		@endforeach
		</div>
	</div>
</section>