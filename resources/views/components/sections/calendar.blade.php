<section class="py-5">
  <div class="container">
	<h2 class="text-center fw-bold mb-2">{{ $section->title }}</h2>
	<p class="text-center text-muted mb-5">{{ $section->content['subtitle'] ?? '' }}</p>
	<div id="public-calendar"></div>
  </div>
</section>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
	new FullCalendar.Calendar(document.getElementById('public-calendar'), {
	  initialView: 'dayGridMonth',
	  headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,listWeek' }
	}).render();
  });
</script>