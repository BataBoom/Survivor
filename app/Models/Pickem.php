<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Pickem extends Model
{
    use HasFactory;
    protected $table = 'pickem';

    protected $guarded = [];

    protected $casts = [];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* Testing a diff approach vs Survivor, could prove to be better */
    public function pool()
    {
        return $this->belongsTo(SurvivorRegistration::class, 'ticket_id');
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

    public static function getGradedPicksByUser(User $user)
    {
        return self::where('user_id', $user->id)
            ->whereNotNull('result')
            ->where('week', $week)
            ->latest()
            ->get();
    }

    public static function getNonGradedPicksByUser(User $user, int $week)
    {
        return self::where('user_id', $user->id)
            ->whereNull('result')
            ->where('week', $week)
            ->latest()
            ->get();
    }
    public static function scopeMostForGame($query, $gameID)
    {
        return $query->where('game_id', $gameID)
            ->select('selection', DB::raw('COUNT(*) * 100 / SUM(COUNT(*)) OVER() as percentage'))
            ->groupBy('selection')
            ->orderByDesc('percentage');
    }

    public static function scopeHasStarted($query, $gameID, $timestamp)
    {

        return $query->where('game_id', $gameID)
            ->where('starts_at', '>', $timestamp)
            ->exists();
    }

}
