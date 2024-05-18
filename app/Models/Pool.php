<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pool extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'survivor_pools';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;


    //Relationship for adding users to this pool
    public function registration()
    {
        return $this->hasOne(SurvivorRegistration::class, 'pool_id');
    }

    //Only return users that are still alive
    public function survivors()
    {
        return $this->hasManyThrough(
            User::class,
            SurvivorRegistration::class,
            'pool_id', // Foreign key on SurvivorRegistration table...
            'id',      // Foreign key on User table...
            'id',      // Local key on Pool table...
            'user_id'  // Local key on SurvivorRegistration table...
        )->where('alive', true);
    }

    //Return all users that registered to the pool
    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            SurvivorRegistration::class,
            'pool_id', // Foreign key on SurvivorRegistration table...
            'id',      // Foreign key on User table...
            'id',      // Local key on Pool table...
            'user_id'  // Local key on SurvivorRegistration table...
        );
    }

    //Relationship to Pool Creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

}
