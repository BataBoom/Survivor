<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

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

    //Update Manually from Dummy Pools after theyre created
    public const DummyPrizes = [
        "9c35cbef-a356-40fe-931c-21bfc18733d6" => '0.01 BTC',
        "9c35cc31-231c-43f6-aa51-d86d17512e1e" => '0.005 BTC',
        "9c35c839-713e-4ad2-9d38-585f56a9d521" => "0.0",
    ];

    //Relationship to payments

    public function payments()
    {
        return $this->hasMany(Payment::class, 'pool_id', 'id');
    }

    public function getTotalPrizeAttribute()
    {
        if(in_array($this->id, array_keys(Self::DummyPrizes))) {
            return Self::DummyPrizes[$this->id];
        } else {
            return '$'.number_format($this->payments->sum('amount_usd'), 2);
            //return '$'.number_format($this->guaranteed_prize + $this->payments->sum('amount_usd'), 2);
        }
    }


    public function getTotalSetupCostAttribute()
    {
        return number_format($this->guaranteed_prize + $this->entry_cost, 2);
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

    //Relationship for viewing Pool Count
    public function Alive()
    {
        return $this->hasMany(SurvivorRegistration::class, 'pool_id')->where('alive', true);
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

    //Relationship to Survivor
    public function allSurvivors()
    {
        return $this->hasManyThrough(
            Survivor::class,
            SurvivorRegistration::class,
            'pool_id', // Foreign key on SurvivorRegistration table...
            'ticket_id',      // Foreign key on Survivor table...
        );
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

    //Chatroom
    public function messages()
    {
        return $this->hasMany(Message::class, 'pool_chat_id');
    }

    //Relationship to DummyPool
    public function promoable()
    {
        return $this->morphTo();
    }


}
