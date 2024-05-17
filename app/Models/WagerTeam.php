<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WagerTeam extends Model
{
    use HasFactory;
    protected $table = 'wager_teams';
    protected $fillable = ['team_id', 'league','name','abbreviation', 'color', 'altColor', 'location'];
    protected $primaryKey = 'id';
    public $incrementing = true;

    public function schedule()
    {
        return $this->hasManyThrough(
            WagerQuestion::class,
            WagerOption::class,
            'team_id',
            'game_id',
            'team_id',
            'game_id'
        )->orderBy('week');
    }

    public function results()
    {
        return $this->hasMany(WagerResult::class, 'winner', 'team_id')->orderBy('week');
    }

    public function UpcomingGames() {
        return $this->games->where('ended', false);
    }

    public function PastGames() {
        return $this->games->where('ended', true);
    }

    public function options()
    {
        return $this->hasMany(WagerOption::class, 'team_id', 'team_id');
    }
}
