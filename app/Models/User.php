<?php

namespace App\Models;

use App\Traits\Scope\IsActive;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, HasUuids, IsActive, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'username',
        'phone',
        'active',
        'percent',
        'avatar',
        'address',
        'gender',
        'birthday',
        'fin',
        'bank_id',
        'restricted',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarPhotoAttribute(): string
    {
        return $this->avatar ? '/uploads/users/'.$this->avatar : '/uploads/avatar.png';
    }

    public function getFullNameAttribute(): string
    {
        return ucfirst($this->name).' '.ucfirst($this->surname);
    }

    public function getNameShortAttribute(): string
    {
        return ucfirst($this->name).' '.ucfirst($this->surname[0]);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isRestricted(): bool
    {
        return $this->restricted;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
