<?php
namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Dashboard: show the welcome page builder
    public function edit()
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);
        $page     = Page::where('slug', 'welcome')->firstOrFail();
        $sections = $page->sections;
        $types    = PageSection::types();
        return view('content.pages.edit', compact('page', 'sections', 'types'));
    }

    // Update page settings (including file uploads)
	public function update(Request $request): \Illuminate\Http\RedirectResponse
	{
		abort_unless(auth()->user()->can('pages.edit'), 403);

		$page = Page::where('slug', 'welcome')->firstOrFail();

		$request->validate([
			'title'           => 'required|string|max:255',
			'meta_description'=> 'nullable|string|max:500',
			'logo'            => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
			'favicon'         => 'nullable|file|mimes:ico,png,svg|max:512',
			'seo_title'       => 'nullable|string|max:70',
			'seo_description' => 'nullable|string|max:160',
			'seo_keywords'    => 'nullable|string|max:255',
			'og_title'        => 'nullable|string|max:95',
			'og_description'  => 'nullable|string|max:200',
			'og_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
			'twitter_card'    => 'nullable|in:summary,summary_large_image',
			'twitter_site'    => 'nullable|string|max:50',
			'canonical_url'   => 'nullable|url|max:255',
			'schema_markup'   => 'nullable|string',
		]);

		$dir = public_path('/img/site');
		if (!file_exists($dir)) mkdir($dir, 0755, true);

		// Nav items: sent as JSON string from the editor
		$navItems = null;
		if ($request->filled('nav_items_json')) {
			$decoded = json_decode($request->input('nav_items_json'), true);
			if (is_array($decoded)) $navItems = $decoded;
		}

		$data = [
			'title'            => $request->title,
			'meta_description' => $request->meta_description,
			'is_published'     => $request->boolean('is_published'),
			'seo_title'        => $request->seo_title,
			'seo_description'  => $request->seo_description,
			'seo_keywords'     => $request->seo_keywords,
			'og_title'         => $request->og_title,
			'og_description'   => $request->og_description,
			'twitter_card'     => $request->twitter_card ?? 'summary_large_image',
			'twitter_site'     => $request->twitter_site,
			'canonical_url'    => $request->canonical_url,
			'schema_markup'    => $request->schema_markup
									? json_decode($request->schema_markup, true)
									: null,
			'nav_enabled'      => $request->boolean('nav_enabled'),
			'nav_position'     => $request->input('nav_position', 'normal'),
			'nav_items'        => $navItems,
			'whatsapp'         => preg_replace('/[^0-9]/', '', $request->whatsapp ?? '') ?: null,
		];

		// Logo — file upload takes priority; fallback to media manager URL
		if ($request->hasFile('logo')) {
			if ($page->logo && !str_starts_with($page->logo, 'http')) @unlink(public_path('/img/site/' . $page->logo));
			$file = $request->file('logo');
			$name = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
			$file->move($dir, $name);
			$data['logo'] = $name;
		} elseif ($request->filled('logo_media')) {
			$data['logo'] = $request->logo_media;
		}

		// Favicon — file upload takes priority; fallback to media manager URL
		if ($request->hasFile('favicon')) {
			if ($page->favicon && !str_starts_with($page->favicon, 'http')) @unlink(public_path('/img/site/' . $page->favicon));
			$file = $request->file('favicon');
			$name = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
			$file->move($dir, $name);
			$data['favicon'] = $name;
		} elseif ($request->filled('favicon_media')) {
			$data['favicon'] = $request->favicon_media;
		}

		// OG Image — file upload takes priority; fallback to media manager URL
		if ($request->hasFile('og_image')) {
			if ($page->og_image && !str_starts_with($page->og_image, 'http')) @unlink(public_path('/img/site/' . $page->og_image));
			$file = $request->file('og_image');
			$name = 'og_' . time() . '.' . $file->getClientOriginalExtension();
			$file->move($dir, $name);
			$data['og_image'] = $name;
		} elseif ($request->filled('og_image_media')) {
			$data['og_image'] = $request->og_image_media;
		}

		$page->update($data);

		return back()->with('success', 'Page settings saved.');
	}

    // Add a new section
    public function addSection(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);
        $request->validate([
            'type' => 'required|in:hero,features,pricing,calendar,gallery,testimonial,faq,cta,custom,vcard',
        ]);

        $page     = Page::where('slug', 'welcome')->firstOrFail();
        $maxOrder = $page->sections()->max('order') ?? 0;

        $defaults = [
            'hero' => [
                'slides' => [[
                    'title'       => 'Welcome',
                    'subtitle'    => 'Your tagline here',
                    'button_text' => 'Get Started',
                    'button_url'  => '#',
                    'bg_color'    => '#696cff',
                ]],
            ],
            'features' => [
                'columns' => 3,
                'items'   => [
                    ['icon' => 'bx-rocket',  'title' => 'Fast',    'description' => 'Lightning fast performance'],
                    ['icon' => 'bx-shield',  'title' => 'Secure',  'description' => 'Enterprise grade security'],
                    ['icon' => 'bx-support', 'title' => 'Support', 'description' => '24/7 dedicated support'],
                ],
            ],
            'pricing' => [
                'columns' => 3,
                'plans'   => [
                    ['name' => 'Basic',      'price' => '9',  'period' => 'mo', 'features' => ['Feature 1', 'Feature 2'],                              'button_text' => 'Start Free',   'highlighted' => false],
                    ['name' => 'Pro',        'price' => '29', 'period' => 'mo', 'features' => ['Everything in Basic', 'Feature 3', 'Feature 4'],        'button_text' => 'Get Pro',      'highlighted' => true],
                    ['name' => 'Enterprise', 'price' => '99', 'period' => 'mo', 'features' => ['Everything in Pro', 'Feature 5', 'Priority Support'],   'button_text' => 'Contact Us',   'highlighted' => false],
                ],
            ],
            'calendar' => [
                'title'    => 'Our Events',
                'subtitle' => 'Stay up to date with our latest events',
            ],
            'gallery' => [
                'columns' => 3,
                'items'   => [
                    ['image' => '', 'caption' => 'Image 1'],
                    ['image' => '', 'caption' => 'Image 2'],
                    ['image' => '', 'caption' => 'Image 3'],
                ],
            ],
            'testimonial' => [
                'columns' => 3,
                'items'   => [
                    ['name' => 'Jane Doe',    'role' => 'CEO, Acme',    'avatar' => '', 'text' => 'This product changed our workflow completely.', 'rating' => 5],
                    ['name' => 'John Smith',  'role' => 'Developer',    'avatar' => '', 'text' => 'Incredibly easy to use and well documented.',  'rating' => 5],
                    ['name' => 'Sara Connor', 'role' => 'Product Lead', 'avatar' => '', 'text' => 'Best investment we made this year.',            'rating' => 4],
                ],
            ],
            'faq' => [
                'items' => [
                    ['question' => 'What is this product?',     'answer' => 'A brief answer goes here.'],
                    ['question' => 'How do I get started?',     'answer' => 'A brief answer goes here.'],
                    ['question' => 'Is there a free trial?',    'answer' => 'A brief answer goes here.'],
                    ['question' => 'How do I contact support?', 'answer' => 'A brief answer goes here.'],
                ],
            ],
            'cta' => [
                'heading'      => 'Ready to get started?',
                'subheading'   => 'Join thousands of happy customers today.',
                'button_text'  => 'Get Started',
                'button_url'   => '#',
                'bg_color'     => '#696cff',
                'text_color'   => '#ffffff',
                'button_bg'    => '#ffffff',
                'button_color' => '#696cff',
                'align'        => 'center',
            ],
            'custom' => [
                'html' => '<p>Add your custom content here.</p>',
            ],
            'vcard' => [
                'first_name'   => 'John',
                'last_name'    => 'Doe',
                'organization' => 'Mi Empresa S.A.',
                'title'        => 'Director General',
                'email'        => 'contacto@ejemplo.com',
                'phone_mobile' => '+52 55 1234 5678',
                'phone_work'   => '',
                'website'      => 'https://ejemplo.com',
                'address'      => '',
                'city'         => '',
                'state'        => '',
                'zip'          => '',
                'country'      => 'MX',
                'linkedin'     => '',
                'twitter'      => '',
                'instagram'    => '',
                'note'         => '',
                'photo_url'    => '',
                'bg_color'     => '#696cff',
                'text_color'   => '#ffffff',
                'btn_label'    => 'Guardar Contacto',
            ],
        ];

        $section = $page->sections()->create([
            'type'       => $request->type,
            'title'      => PageSection::types()[$request->type]['label'],
            'content'    => $defaults[$request->type],
            'order'      => $maxOrder + 1,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Section added.');
    }

    public function updateSection(Request $request, PageSection $section)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $content = $request->input('content', []);

        // ── Hero ─────────────────────────────────────────────────────────
        if ($section->type === 'hero') {
            if (isset($content['settings'])) {
                $s = $content['settings'];
                $content['settings'] = [
                    'autoplay'    => isset($s['autoplay']),
                    'speed'       => (int)($s['speed']       ?? 5000),
                    'height'      => (int)($s['height']      ?? 480),
                    'show_arrows' => isset($s['show_arrows']),
                    'show_dots'   => isset($s['show_dots']),
                ];
            }
            if (isset($content['slides'])) {
                foreach ($content['slides'] as &$slide) {
                    if (!empty($slide['bg_color_hex']))            $slide['bg_color']          = $slide['bg_color_hex'];
                    if (!empty($slide['title_color_hex']))         $slide['title_color']        = $slide['title_color_hex'];
                    if (!empty($slide['subtitle_color_hex']))      $slide['subtitle_color']     = $slide['subtitle_color_hex'];
                    if (!empty($slide['button_bg_hex']))           $slide['button_bg']          = $slide['button_bg_hex'];
                    if (!empty($slide['button_color_hex']))        $slide['button_color']       = $slide['button_color_hex'];
                    if (!empty($slide['button_hover_bg_hex']))     $slide['button_hover_bg']    = $slide['button_hover_bg_hex'];
                    if (!empty($slide['button_hover_color_hex']))  $slide['button_hover_color'] = $slide['button_hover_color_hex'];
                    unset(
                        $slide['bg_color_hex'], $slide['title_color_hex'], $slide['subtitle_color_hex'],
                        $slide['button_bg_hex'], $slide['button_color_hex'],
                        $slide['button_hover_bg_hex'], $slide['button_hover_color_hex']
                    );
                }
                unset($slide);
            }
        }

        // ── Pricing ───────────────────────────────────────────────────────
        if ($section->type === 'pricing' && isset($content['plans'])) {
            foreach ($content['plans'] as &$plan) {
                if (isset($plan['features_text'])) {
                    $plan['features'] = array_values(array_filter(
                        array_map('trim', explode("\n", $plan['features_text']))
                    ));
                    unset($plan['features_text']);
                }
                $plan['highlighted'] = isset($plan['highlighted']);
            }
            unset($plan);
        }

        // ── Testimonial: cast rating to int ───────────────────────────────
        if ($section->type === 'testimonial' && isset($content['items'])) {
            foreach ($content['items'] as &$item) {
                $item['rating'] = (int)($item['rating'] ?? 5);
            }
            unset($item);
        }

        // ── CTA: resolve hex fields ───────────────────────────────────────
        if ($section->type === 'cta') {
            foreach (['bg_color', 'text_color', 'button_bg', 'button_color'] as $field) {
                $hex = $field . '_hex';
                if (!empty($content[$hex])) {
                    $content[$field] = $content[$hex];
                }
                unset($content[$hex]);
            }
        }

        // Sanitize anchor: lowercase, only a-z 0-9 hyphens/underscores
        $anchor = $request->input('anchor');
        if ($anchor) {
            $anchor = preg_replace('/[^a-z0-9_-]/i', '', strtolower(trim($anchor))) ?: null;
        }

        $section->update([
            'title'      => $request->title,
            'anchor'     => $anchor ?: null,
            'is_visible' => $request->boolean('is_visible'),
            'content'    => $content,
        ]);

        return back()->with('success', 'Section saved.');
    }

    public function uploadSlideImage(Request $request): \Illuminate\Http\JsonResponse
	{
		abort_unless(auth()->user()->can('pages.edit'), 403);

		$request->validate([
			'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
		]);

		// Save to public/img/slider/
		$file     = $request->file('image');
		$filename = time() . '_' . \Illuminate\Support\Str::slug(
			pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
		) . '.' . $file->getClientOriginalExtension();

		$destination = public_path('img/slider');

		if (!file_exists($destination)) {
			mkdir($destination, 0755, true);
		}

		$file->move($destination, $filename);

		$url = asset('img/slider/' . $filename);

		return response()->json(['success' => true, 'url' => $url]);
	}

	public function deleteSection(PageSection $section): \Illuminate\Http\RedirectResponse
	{
		abort_unless(auth()->user()->can('pages.delete'), 403);

		// Clean up uploaded slider images
		if ($section->type === 'hero') {
			foreach ($section->content['slides'] ?? [] as $slide) {
				if (!empty($slide['bg_image'])) {
					$urlPath = parse_url($slide['bg_image'], PHP_URL_PATH);
					// Normalize path relative to public/
					$rel  = ltrim(str_replace(parse_url(asset('/'), PHP_URL_PATH), '', $urlPath), '/');
					$path = public_path($rel);
					if ($rel && file_exists($path)) {
						unlink($path);
					}
				}
			}
		}

		$section->delete();
		return redirect()->route('pages.edit')->with('success', 'Section deleted.');
	}

    // Reorder sections via drag-and-drop (AJAX)
    public function reorderSections(Request $request)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);
        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $position => $sectionId) {
            PageSection::where('id', $sectionId)->update(['order' => $position]);
        }

        return response()->json(['success' => true]);
    }

    // Toggle section visibility
    public function toggleSection(PageSection $section)
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);
        $section->update(['is_visible' => !$section->is_visible]);
        return back()->with('success', 'Section visibility updated.');
    }

    // Download vCard (.vcf)
    public function downloadVcard(PageSection $section)
    {
        abort_if($section->type !== 'vcard', 404);

        $c = $section->content ?? [];

        $lines = ['BEGIN:VCARD', 'VERSION:3.0'];

        $last  = $this->vcfEscape($c['last_name']  ?? '');
        $first = $this->vcfEscape($c['first_name'] ?? '');
        $lines[] = "N:{$last};{$first};;;";
        $lines[] = 'FN:' . trim("{$first} {$last}");

        if (!empty($c['organization'])) $lines[] = 'ORG:'   . $this->vcfEscape($c['organization']);
        if (!empty($c['title']))        $lines[] = 'TITLE:' . $this->vcfEscape($c['title']);
        if (!empty($c['email']))        $lines[] = 'EMAIL;TYPE=INTERNET:' . $c['email'];
        if (!empty($c['phone_mobile'])) $lines[] = 'TEL;TYPE=CELL:'       . $c['phone_mobile'];
        if (!empty($c['phone_work']))   $lines[] = 'TEL;TYPE=WORK:'       . $c['phone_work'];
        if (!empty($c['website']))      $lines[] = 'URL:'  . $c['website'];

        $street  = $this->vcfEscape($c['address'] ?? '');
        $city    = $this->vcfEscape($c['city']    ?? '');
        $state   = $this->vcfEscape($c['state']   ?? '');
        $zip     = $this->vcfEscape($c['zip']     ?? '');
        $country = $this->vcfEscape($c['country'] ?? '');
        if ($street || $city || $state || $zip || $country) {
            $lines[] = "ADR;TYPE=WORK:;;{$street};{$city};{$state};{$zip};{$country}";
        }

        if (!empty($c['linkedin']))  $lines[] = 'X-SOCIALPROFILE;TYPE=linkedin:'  . $c['linkedin'];
        if (!empty($c['twitter']))   $lines[] = 'X-SOCIALPROFILE;TYPE=twitter:'   . $c['twitter'];
        if (!empty($c['instagram'])) $lines[] = 'X-SOCIALPROFILE;TYPE=instagram:' . $c['instagram'];
        if (!empty($c['note']))      $lines[] = 'NOTE:'  . $this->vcfEscape($c['note']);
        if (!empty($c['photo_url'])) $lines[] = 'PHOTO;VALUE=URI:' . $c['photo_url'];

        $lines[] = 'END:VCARD';

        $vcf      = implode("\r\n", $lines) . "\r\n";
        $filename = \Illuminate\Support\Str::slug(trim("{$first} {$last}") ?: 'contacto') . '.vcf';

        return response($vcf, 200, [
            'Content-Type'        => 'text/vcard; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function vcfEscape(string $value): string
    {
        return str_replace([',', ';', "\n"], ['\\,', '\\;', '\\n'], $value);
    }

    // Public welcome page
    public function welcome()
    {
        $page = Page::where('slug', 'welcome')->where('is_published', true)->firstOrFail();
        $sections = $page->visibleSections;
        return view('welcome', compact('page', 'sections'));
    }
}