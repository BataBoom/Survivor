<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
	    'email_verified_at',
        'subscribed',
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
        'subscribed' => 'boolean',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->id === 1;
    }

    public function getAvatarAttribute()
    {
	$colors = ['26f00d', '1b8c78', '641d2e', 'e86654', '880487', '1e67e2', '048ed3', 'f7931a', 'd0cb65', '6c63ff'];
        $color = $colors[array_rand($colors)];
        return 'https://ui-avatars.com/api/?rounded=true&name='.$this->name.'&color='.$color.'&background=404143';
    }

    // Relationship With Pool (CREATOR)
    public function createdPools() {
        return $this->hasMany(Pool::class, 'creator_id', 'id');
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

    public function payments() {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function MyPicks()
    {
        return $this->hasMany(
            Survivor::class,
            'user_id', // Foreign key on the Survivor table...
            'id', // Local key on the Users table...
        )->orderBy('week', 'asc');
    }


    public function isAdmin(): bool
    {
        return $this->id === 1;
    }

    /* Model for pending deletions..
    * Yes Kinda ghetto but idc.. it works.
    */
    public function DeleteUser()
    {
        return $this->hasOne(DeleteUser::class, 'user_id', 'id');
    }

    /* Determine if user has wanted to delete itself
    *
    */
    public function hasDeletedSelf(): bool
    {
        return $this->DeleteUser ? true : false;
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'user_id');
    }

}
