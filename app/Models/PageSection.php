<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = ['page_id', 'type', 'title', 'content', 'order', 'is_visible'];

    protected $casts = [
        'content'    => 'array',
        'is_visible' => 'boolean',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    // Section type labels for the UI
    public static function types(): array
    {
        return [
            'hero'     => ['label' => 'Hero Slider',       'icon' => 'bx-images'],
            'features'    => ['label' => 'Features Section',   'icon' => 'bx-star'],
            'pricing'     => ['label' => 'Pricing Section',    'icon' => 'bx-purchase-tag'],
            'calendar'    => ['label' => 'Calendar Section',   'icon' => 'bx-calendar'],
            'gallery'     => ['label' => 'Gallery Section',    'icon' => 'bx-photo-album'],
            'testimonial' => ['label' => 'Testimonials',       'icon' => 'bx-comment-dots'],
            'faq'         => ['label' => 'FAQ Section',        'icon' => 'bx-help-circle'],
            'cta'         => ['label' => 'Call to Action',     'icon' => 'bx-bullseye'],
            'custom'      => ['label' => 'Custom HTML Block',  'icon' => 'bx-code-alt'],
        ];
    }
}