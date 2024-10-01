<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Services\BettingOdds;

class BetSlip extends Model
{
    use HasFactory;

    protected $table = 'bet_slips';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'starts_at' => 'datetime',
        'result' => 'boolean',
    ];

    protected $dispatchesEvents = [
        //'updated' => SurvivorGradedEvent::class,
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(BetType::class, 'bet_type');
    }

    public function league()
    {
        return $this->belongsTo(League::class, 'league_id');
    }

    public function pick()
    {
        return $this->belongsTo(WagerTeam::class, 'selection_id');
    }

    public function question()
    {
        return $this->hasOne(WagerQuestion::class, 'game_id', 'game_id');
    }

    public function results()
    {
        return $this->hasOne(WagerResult::class, 'game', 'game_id');
    }

    public function getEventAttribute()
    {
        return $this->question?->question ?? $this->unscheduled_event;
    }

    public function getSelectionAttribute()
    {
        return $this->pick?->name ?? $this->option; 
    }

    public function getProfitAttribute()
    {
        $bettingSrvc = new BettingOdds;
        $bettingSrvc->bettingAmount = $this->bet_amount;
        $bettingSrvc->odds = $this->odds;
        
        return $bettingSrvc->toPayout();
    }
}
