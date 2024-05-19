<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
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

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->id === 1;
    }

    // Relationship With SurvivorRegistration
    public function pools() {
        return $this->hasMany(SurvivorRegistration::class, 'user_id', 'id');
    }

    // Relationship With SurvivorRegistration (tracker for survivor)
    public function survivorPools()
    {
        return $this->hasMany(SurvivorRegistration::class, 'user_id', 'id')
            ->where('alive', true)
            ->whereHas('pool', function ($query) {
                $query->where('type', 'survivor');
            });
    }

    public function pickemPools()
    {
        return $this->hasMany(SurvivorRegistration::class, 'user_id', 'id')
            ->where('alive', true)
            ->whereHas('pool', function ($query) {
                $query->where('type', 'pickem');
            });
    }

    public function mypickems()
    {
        return $this->hasMany(Pickem::class, 'user_id');
    }

    // Relationship With Survivor Pools (Generic)
    public function survivorRegistrations() {

        return $this->hasManyThrough(
            Pool::class,
            SurvivorRegistration::class,
            'user_id', // Foreign key on SurvivorRegistration table...
            'id',      // Foreign key on Pool table...
            'id',      // Local key on User table...
            'pool_id'  // Local key on SurvivorRegistration table...
        )->where('type', 'survivor');

    }

    // Relationship With User Created Pools (Generic)
    public function MyPools() {
        return $this->hasMany(Pool::class, 'creator_id');
    }

    public function MyPicks()
    {
        return $this->hasMany(
            Survivor::class,
            'user_id', // Foreign key on the Survivor table...
            'id', // Local key on the Users table...
        )->orderBy('week', 'asc');
    }

    public function sp()
    {
        return $this->hasMany(Survivor::class, 'user_id', 'id')
            ->where('pool', function ($query) {
                $query->where('type', 'pickem');
            });
    }

}
