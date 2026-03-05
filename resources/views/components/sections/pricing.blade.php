@php
	$plans = $section->content['plans'] ?? [];
	$cols  = 12 / ($section->content['columns'] ?? 3);
@endphp
<section class="py-5 bg-light">
  <div class="container">
	<h2 class="text-center fw-bold mb-5">{{ $section->title }}</h2>
	<div class="row g-4 justify-content-center align-items-center">
	  @foreach($plans as $plan)
	  <div class="col-md-{{ $cols }}">
		<div class="card h-100 pricing-card {{ ($plan['highlighted'] ?? false) ? 'highlighted' : '' }}">
		  <div class="card-body text-center p-4">
			<h5 class="fw-bold mb-3">{{ $plan['name'] ?? '' }}</h5>
			<div class="display-5 fw-bold text-primary mb-1">
			  ${{ $plan['price'] ?? '0' }}
			</div>
			<small class="text-muted">/ {{ $plan['period'] ?? 'mo' }}</small>
			<ul class="list-unstyled mt-4 mb-4">
			  @foreach($plan['features'] ?? [] as $feature)
			  <li class="py-1 border-bottom">
				<i class="bx bx-check text-success me-1"></i>{{ $feature }}
			  </li>
			  @endforeach
			</ul>
			<a href="{{ route('register') }}"
			   class="btn w-100 {{ ($plan['highlighted'] ?? false) ? 'btn-primary' : 'btn-outline-primary' }}">
			  {{ $plan['button_text'] ?? 'Get Started' }}
			</a>
		  </div>
		</div>
	  </div>
	  @endforeach
	</div>
  </div>
</section>