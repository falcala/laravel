<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'phone',
        'birthday',
        'profile_picture',
        'google_id',
    ];

    protected $hidden = ['password', 'remember_token' ];
	
	protected $casts = [
        'birthday' => 'date',
    ];
	
    public function frontPage(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\Page::class);
    }

	public function getProfilePictureUrlAttribute(): string
    {
        if ($this->profile_picture && file_exists(storage_path('app/public/' . $this->profile_picture))) {
            return asset('storage/' . $this->profile_picture);
        }
        return asset('assets/img/avatars/default.png');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
			'birthday' => 'date',
        ];
    }
}
