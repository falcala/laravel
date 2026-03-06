<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'title', 'meta_description', 'is_published',
        'logo', 'favicon',
        'seo_title', 'seo_description', 'seo_keywords',
        'og_title', 'og_description', 'og_image',
        'twitter_card', 'twitter_site',
        'canonical_url', 'schema_markup',
        'nav_items', 'nav_position', 'nav_enabled',
        'whatsapp',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    protected $casts = [
        'is_published'  => 'boolean',
        'nav_enabled'   => 'boolean',
        'schema_markup' => 'array',
        'nav_items'     => 'array',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('order');
    }

    public function visibleSections(): HasMany
    {
        return $this->hasMany(PageSection::class)
            ->where('is_visible', true)
            ->orderBy('order');
    }

    // Helpers — support both plain filenames (img/site/) and full URLs (from media manager)
    private function resolveAssetUrl(?string $value, string $prefix): ?string
    {
        if (!$value) return null;
        if (str_starts_with($value, 'http') || str_starts_with($value, '/')) return $value;
        return asset($prefix . $value);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->logo, 'img/site/');
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->favicon, 'img/site/');
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->og_image, 'img/site/');
    }
}