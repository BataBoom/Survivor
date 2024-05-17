<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationship With SurvivorRegistration
    public function pools() {
        return $this->hasMany(SurvivorRegistration::class, 'user_id', 'id');
    }

    public function SurvivorPicks()
    {
        return $this->hasMany(
            Survivor::class,
            'user_id', // Foreign key on the Survivor table...
            'id', // Local key on the Users table...
        )->orderBy('week', 'asc');
    }

   public function isSurvivorAttribute($pool): bool
   {
       return $this->SurvivorPicks()->where('pool', $pool)->whereNot('result', false)->exists();
   }

    /* Pickem */
    public function myPickemPicks()
    {
        return $this->hasMany(
            Pickem::class,
            'uid', // Foreign key on the Survivor table...
            'id', // Local key on the Users table...
        )->orderBy('week', 'asc');
    }
}
