<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;


class SurvivorRegistration extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'survivor_registrations';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    public function pool()
    {
        return $this->belongsTo(Pool::class, 'pool_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'ticket_id');
    }

    public function picks()
    {
        //return $this->hasMany(Survivor::class, 'user_id', 'user_id')->where('pool_id', $this->pool_id)->orderBy('week');
        return $this->hasMany(Survivor::class, 'ticket_id', 'id')->orderBy('week');
    }

    public function pickems()
    {
        return $this->hasMany(Pickem::class, 'ticket_id', 'id')->orderBy('week');
    }

    public function survivorPicks()
    {
        //return $this->hasMany(Survivor::class, 'user_id', 'user_id')->where('ticket_id', $this->id)->orderBy('week');
        return $this->hasMany(Survivor::class, 'ticket_id', 'id')->orderBy('week');
    }


    public function tickets()
    {
        return $this->hasMany(Survivor::class, 'user_id', 'user_id')->where('ticket_id', $this->id);
    }


    public function scopeAlive(Builder $query)
    {
        return $query->where('alive', 1);
    }

    public function scopeSurvivorsAlive($query)
    {
        return $query->whereRelation('pool', 'type', 'survivor')
            ->where('alive', true);
    }

}
