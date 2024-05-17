<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WagerOption extends Model
{
    use HasFactory;
    protected $table = 'wager_options';
    protected $fillable = ['game_id', 'team_id', 'option', 'status'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function question()
    {
    return $this->belongsTo(WagerQuestion::class, 'game_id', 'game_id');
    }

    public function team()
    {
    return $this->belongsTo(WagerTeam::class, 'team_id', 'team_id');
    }

    //Relationship to Survivor Picks
    public function wagers()
    {
    return $this->hasMany(Survivor::class, 'selection_id', 'team_id');
    }

    //Relationship to WagerResults
    public function result()
    {
        return $this->hasOne(WagerResult::class, 'game', 'game_id');
    }

    //Determine if this WagerOption is a winner
    public function getWinnerAttribute()
    {
        if($this->result) {
            return $this->result->winner === $this->team_id;
        } else {
            return null;
        }

    }
    
}
