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

    public function question()
    {
    return $this->belongsTo(WagerQuestion::class, 'game', 'gameid');
    }

    public function result()
    {
    return $this->hasOne(WagerOption::class, 'team_id', 'winner');
    }

    public function teams()
    {
    return $this->hasMany(WagerOption::class, 'game_id', 'game');
    }
}
