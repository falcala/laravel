<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = [
        'slug', 'title', 'meta_description', 'is_published',
        'logo', 'favicon',
        'seo_title', 'seo_description', 'seo_keywords',
        'og_title', 'og_description', 'og_image',
        'twitter_card', 'twitter_site',
        'canonical_url', 'schema_markup',
    ];

    protected $casts = [
        'is_published'  => 'boolean',
        'schema_markup' => 'array',
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

    // Helpers
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('img/site/' . $this->logo) : null;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon ? asset('img/site/' . $this->favicon) : null;
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? asset('img/site/' . $this->og_image) : null;
    }
}