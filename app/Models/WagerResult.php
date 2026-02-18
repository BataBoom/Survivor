<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WagerResult extends Model
{
    use HasFactory;
    protected $table = 'wager_results';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $appends = ['percentages'];

    public function question()
    {
        return $this->belongsTo(WagerQuestion::class, 'game', 'game_id');
    }

    public function result()
    {
        return $this->hasOne(WagerTeam::class, 'team_id', 'winner')->where('league', 'nfl');
    }

    public function teams()
    {
        return $this->hasMany(WagerOption::class, 'game_id', 'game');
    }

    public function winningTeam()
    {
        return $this->hasOne(WagerTeam::class, 'team_id', 'winner');
    }

    public function survivor()
    {
        return $this->hasMany(Survivor::class, 'game_id', 'game');
    }

    public function pickem()
    {
        return $this->hasMany(Pickem::class, 'game_id', 'game');
    }

    public function getResultScoreAttribute()
    {
        $formatted = $this->home_score >= $this->away_score ? "$this->home_score-$this->away_score" : "$this->away_score-$this->home_score";
        return $formatted;
    }

    public function getPercentagesAttribute(): array
    {
        // Make sure `pickem` is eager loaded to avoid N+1
        $pickem = $this->pickem;

        $total   = $pickem->count();
        $wins    = $pickem->where('result', 1)->count();
        $losses  = $pickem->where('result', 0)->count();

        $winPercentage  = $total > 0 ? ($wins / $total) * 100 : 0;
        $lossPercentage = $total > 0 ? ($losses / $total) * 100 : 0;

        return [
            'Won'  => number_format($winPercentage, 2) . '%',
            'Lost' => number_format($lossPercentage, 2) . '%',
        ];
    }
}
