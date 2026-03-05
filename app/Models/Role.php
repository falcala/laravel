<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $fillable = ['name', 'guard_name', 'is_default'];

    protected $casts = [
        'is_default' => 'boolean',
    ];
	
	protected $attributes = [
		'guard_name' => 'web',
	];

    // Ensures only one role can be default at a time
    public function setAsDefault(): void
    {
        static::where('is_default', true)->update(['is_default' => false]);
        $this->update(['is_default' => true]);
    }

    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }
}