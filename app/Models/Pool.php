<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pool extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'survivor_pools';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    public const TYPES = ['survivor', 'pickem'];

    public const PRIZETYPES = ['crypto', 'credits', 'promotion'];

    //Relationship to payments

    public function payments()
    {
        return $this->hasMany(Payment::class, 'pool_id', 'id');
    }

    public function getTotalPrizeAttribute()
    {
        return $this->prize + $this->payments->sum('amount_usd');
    }

    //Relationship for adding users to this pool
    public function registration()
    {
        return $this->hasMany(SurvivorRegistration::class, 'pool_id');
    }

    //Relationship for viewing Pool Registerees
    public function contenders()
    {
        return $this->hasMany(SurvivorRegistration::class, 'pool_id');
    }

    //Relationship to Survivor
    public function survivors()
    {
        return $this->hasManyThrough(
            Survivor::class,
            SurvivorRegistration::class,
            'pool_id', // Foreign key on SurvivorRegistration table...
            'ticket_id',      // Foreign key on Survivor table...
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

    public function IsSetupAttribute()
    {
        if($this->contenders->isNotEmpty()) {
            return true;
        } else {
            return false;
        }
    }


}
