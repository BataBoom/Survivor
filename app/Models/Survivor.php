<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Survivor extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'survivor';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [];

     public function user()
    {
    return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function whichPool()
    {
    return $this->belongsTo(Pool::class, 'pool_id');
    }
    /*
    public function pool()
    {
    return $this->hasOneThrough(
            SurvivorLog::class,
            User::class,
            'id', // Foreign key on the SurvivorLog table...
            'id', // Foreign key on the users table...
            'uid', // Local key on the Survivor table...
            'id' // Local key on the users table...
        );
    }
    */
    
    public static function getLastGradedPickByUser(User $user)
    {
        return self::where('user_id', $user->id)
            ->where('pool_id', $pool)
            ->whereNotNull('result')
            ->latest()
            ->first();
    }

    public static function getLastPickByUser(User $user, $pool)
    {
        return self::where('user_id', $user->id)
            ->where('pool_id', $pool)
            ->latest()
            ->first();
    }


    public function pick()
    {
    return $this->hasOne(WagerOption::class, 'team_id', 'selection_id');
    }

    public function question()
    {
    return $this->hasOne(WagerQuestion::class, 'game_id', 'game_id');
    }

    public function results()
    {
        return $this->hasOne(WagerResult::class, 'game', 'game_id');
    }


}
