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
    return $this->hasMany(WagerTeam::class, 'team_id', 'team_id');
    }

    public function teaminfo()
    {
    return $this->hasOne(WagerTeam::class, 'team_id', 'team_id');
    }

    public function wagers()
    {
    return $this->hasMany(Wager::class, 'selection_id', 'team_id');
    }
    
}
