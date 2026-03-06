<?php
namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageSection;
use App\Models\User;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    // ── Authorization helpers ─────────────────────────────────────────────

    private function authorizeForUser(User $owner): void
    {
        $me = auth()->user();
        if ($owner->id === $me->id) {
            abort_unless($me->can('frontpages.edit'), 403);
        } else {
            abort_unless($me->can('frontpages.manage'), 403);
        }
    }

    private function authorizeForSection(PageSection $section): void
    {
        $me   = auth()->user();
        $page = $section->page;
        if ($page->user_id === $me->id) {
            abort_unless($me->can('frontpages.edit'), 403);
        } else {
            abort_unless($me->can('frontpages.manage'), 403);
        }
    }

    private function getOrCreatePage(User $owner): Page
    {
        return Page::firstOrCreate(
            ['user_id' => $owner->id],
            [
                'slug'         => 'fp-' . $owner->id,
                'title'        => $owner->name,
                'is_published' => false,
            ]
        );
    }

    // ── Dashboard: list ───────────────────────────────────────────────────

    public function index()
    {
        $me = auth()->user();
        abort_unless($me->can('frontpages.edit') || $me->can('frontpages.manage'), 403);

        if ($me->can('frontpages.manage')) {
            $users = User::with('roles')->orderBy('name')->get();
        } else {
            $users = collect([$me]);
        }

        $pages = Page::whereIn('user_id', $users->pluck('id'))->get()->keyBy('user_id');

        return view('content.frontpages.index', compact('users', 'pages'));
    }

    // ── Dashboard: edit ───────────────────────────────────────────────────

    public function edit(User $user)
    {
        $this->authorizeForUser($user);

        $page      = $this->getOrCreatePage($user);
        $sections  = $page->sections;
        $types     = PageSection::types();
        $pageOwner = $user;

        return view('content.frontpages.edit', compact('page', 'sections', 'types', 'pageOwner'));
    }

    // ── Dashboard: save settings ──────────────────────────────────────────

    public function update(Request $request, User $user)
    {
        $this->authorizeForUser($user);

        $page = $this->getOrCreatePage($user);

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
        ];

        if ($request->hasFile('logo')) {
            if ($page->logo && !str_starts_with($page->logo, 'http')) @unlink(public_path('/img/site/' . $page->logo));
            $file = $request->file('logo');
            $name = 'logo_fp' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $name);
            $data['logo'] = $name;
        } elseif ($request->filled('logo_media')) {
            $data['logo'] = $request->logo_media;
        }

        if ($request->hasFile('favicon')) {
            if ($page->favicon && !str_starts_with($page->favicon, 'http')) @unlink(public_path('/img/site/' . $page->favicon));
            $file = $request->file('favicon');
            $name = 'fav_fp' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $name);
            $data['favicon'] = $name;
        } elseif ($request->filled('favicon_media')) {
            $data['favicon'] = $request->favicon_media;
        }

        if ($request->hasFile('og_image')) {
            if ($page->og_image && !str_starts_with($page->og_image, 'http')) @unlink(public_path('/img/site/' . $page->og_image));
            $file = $request->file('og_image');
            $name = 'og_fp' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $name);
            $data['og_image'] = $name;
        } elseif ($request->filled('og_image_media')) {
            $data['og_image'] = $request->og_image_media;
        }

        $page->update($data);

        return back()->with('success', 'Configuración guardada.');
    }

    // ── Dashboard: add section ────────────────────────────────────────────

    public function addSection(Request $request, User $user)
    {
        $this->authorizeForUser($user);

        $request->validate([
            'type' => 'required|in:hero,features,pricing,calendar,gallery,testimonial,faq,cta,custom,vcard',
        ]);

        $page     = $this->getOrCreatePage($user);
        $maxOrder = $page->sections()->max('order') ?? 0;

        $defaults = [
            'hero' => ['slides' => [['title' => 'Bienvenido', 'subtitle' => 'Tu página personal', 'button_text' => 'Ver más', 'button_url' => '#', 'bg_color' => '#696cff']]],
            'features'    => ['columns' => 3, 'items' => [['icon' => 'bx-rocket', 'title' => 'Rápido', 'description' => ''], ['icon' => 'bx-shield', 'title' => 'Seguro', 'description' => ''], ['icon' => 'bx-support', 'title' => 'Soporte', 'description' => '']]],
            'pricing'     => ['columns' => 3, 'plans' => [['name' => 'Básico', 'price' => '9', 'period' => 'mo', 'features' => ['Feature 1', 'Feature 2'], 'button_text' => 'Empezar', 'highlighted' => false], ['name' => 'Pro', 'price' => '29', 'period' => 'mo', 'features' => ['Todo lo básico', 'Feature 3'], 'button_text' => 'Elegir Pro', 'highlighted' => true], ['name' => 'Enterprise', 'price' => '99', 'period' => 'mo', 'features' => ['Todo Pro', 'Soporte prioritario'], 'button_text' => 'Contactar', 'highlighted' => false]]],
            'calendar'    => ['title' => 'Eventos', 'subtitle' => 'Mantente al día'],
            'gallery'     => ['columns' => 3, 'items' => [['image' => '', 'caption' => 'Imagen 1'], ['image' => '', 'caption' => 'Imagen 2'], ['image' => '', 'caption' => 'Imagen 3']]],
            'testimonial' => ['columns' => 3, 'items' => [['name' => 'Juan Pérez', 'role' => 'CEO', 'avatar' => '', 'text' => 'Excelente trabajo.', 'rating' => 5]]],
            'faq'         => ['items' => [['question' => '¿Pregunta frecuente?', 'answer' => 'Respuesta aquí.']]],
            'cta'         => ['heading' => '¿Listo para empezar?', 'subheading' => '', 'button_text' => 'Contactar', 'button_url' => '#', 'bg_color' => '#696cff', 'text_color' => '#ffffff', 'button_bg' => '#ffffff', 'button_color' => '#696cff', 'align' => 'center'],
            'custom'      => ['html' => '<p>Contenido personalizado.</p>'],
            'vcard'       => ['first_name' => '', 'last_name' => '', 'organization' => '', 'title' => '', 'email' => '', 'phone_mobile' => '', 'phone_work' => '', 'website' => '', 'address' => '', 'city' => '', 'state' => '', 'zip' => '', 'country' => 'MX', 'linkedin' => '', 'twitter' => '', 'instagram' => '', 'note' => '', 'photo_url' => '', 'bg_color' => '#696cff', 'text_color' => '#ffffff', 'btn_label' => 'Guardar Contacto'],
        ];

        $page->sections()->create([
            'type'       => $request->type,
            'title'      => PageSection::types()[$request->type]['label'],
            'content'    => $defaults[$request->type],
            'order'      => $maxOrder + 1,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Sección agregada.');
    }

    // ── Dashboard: update section ─────────────────────────────────────────

    public function updateSection(Request $request, PageSection $section)
    {
        $this->authorizeForSection($section);

        $content = $request->input('content', []);

        if ($section->type === 'hero') {
            if (isset($content['settings'])) {
                $s = $content['settings'];
                $content['settings'] = ['autoplay' => isset($s['autoplay']), 'speed' => (int)($s['speed'] ?? 5000), 'height' => (int)($s['height'] ?? 480), 'show_arrows' => isset($s['show_arrows']), 'show_dots' => isset($s['show_dots'])];
            }
            if (isset($content['slides'])) {
                foreach ($content['slides'] as &$slide) {
                    foreach (['bg_color', 'title_color', 'subtitle_color', 'button_bg', 'button_color', 'button_hover_bg', 'button_hover_color'] as $field) {
                        if (!empty($slide[$field . '_hex'])) $slide[$field] = $slide[$field . '_hex'];
                        unset($slide[$field . '_hex']);
                    }
                }
                unset($slide);
            }
        }

        if ($section->type === 'pricing' && isset($content['plans'])) {
            foreach ($content['plans'] as &$plan) {
                if (isset($plan['features_text'])) {
                    $plan['features'] = array_values(array_filter(array_map('trim', explode("\n", $plan['features_text']))));
                    unset($plan['features_text']);
                }
                $plan['highlighted'] = isset($plan['highlighted']);
            }
            unset($plan);
        }

        if ($section->type === 'testimonial' && isset($content['items'])) {
            foreach ($content['items'] as &$item) { $item['rating'] = (int)($item['rating'] ?? 5); }
            unset($item);
        }

        if ($section->type === 'cta') {
            foreach (['bg_color', 'text_color', 'button_bg', 'button_color'] as $field) {
                if (!empty($content[$field . '_hex'])) $content[$field] = $content[$field . '_hex'];
                unset($content[$field . '_hex']);
            }
        }

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

        return back()->with('success', 'Sección guardada.');
    }

    // ── Dashboard: delete section ─────────────────────────────────────────

    public function deleteSection(PageSection $section)
    {
        $this->authorizeForSection($section);
        $owner = $section->page->user;

        if ($section->type === 'hero') {
            foreach ($section->content['slides'] ?? [] as $slide) {
                if (!empty($slide['bg_image'])) {
                    $rel  = ltrim(str_replace(parse_url(asset('/'), PHP_URL_PATH), '', parse_url($slide['bg_image'], PHP_URL_PATH)), '/');
                    $path = public_path($rel);
                    if ($rel && file_exists($path)) unlink($path);
                }
            }
        }

        $section->delete();
        return redirect()->route('frontpages.edit', $owner)->with('success', 'Sección eliminada.');
    }

    // ── Dashboard: reorder sections ───────────────────────────────────────

    public function reorderSections(Request $request)
    {
        $me = auth()->user();
        abort_unless($me->can('frontpages.edit') || $me->can('frontpages.manage'), 403);

        $request->validate(['order' => 'required|array', 'order.*' => 'integer']);

        foreach ($request->order as $position => $sectionId) {
            $section = PageSection::find($sectionId);
            if (!$section) continue;
            $page = $section->page;
            if ($page->user_id !== $me->id && !$me->can('frontpages.manage')) continue;
            $section->update(['order' => $position]);
        }

        return response()->json(['success' => true]);
    }

    // ── Dashboard: toggle section ─────────────────────────────────────────

    public function toggleSection(PageSection $section)
    {
        $this->authorizeForSection($section);
        $section->update(['is_visible' => !$section->is_visible]);
        return back()->with('success', 'Visibilidad actualizada.');
    }

    // ── Dashboard: upload slide image ─────────────────────────────────────

    public function uploadSlideImage(Request $request)
    {
        $me = auth()->user();
        abort_unless($me->can('frontpages.edit') || $me->can('frontpages.manage'), 403);

        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096']);

        $file     = $request->file('image');
        $filename = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $dest     = public_path('img/slider');
        if (!file_exists($dest)) mkdir($dest, 0755, true);
        $file->move($dest, $filename);

        return response()->json(['success' => true, 'url' => asset('img/slider/' . $filename)]);
    }

    // ── Public: show front page ───────────────────────────────────────────

    public function show(string $nickname)
    {
        $user = User::where('nickname', $nickname)->firstOrFail();
        $page = Page::where('user_id', $user->id)->first();

        if (!$page || !$page->is_published) {
            // Check if viewing own unpublished page while logged in
            if (auth()->check() && auth()->id() === $user->id) {
                return view('frontpage', ['page' => $page, 'sections' => $page ? $page->visibleSections : collect(), 'pageOwner' => $user, 'isDraft' => true]);
            }
            abort(404);
        }

        $sections = $page->visibleSections;
        return view('frontpage', compact('page', 'sections', 'user') + ['pageOwner' => $user, 'isDraft' => false]);
    }
}
