<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class WagerQuestion extends Model
{
    use HasFactory;
    protected $table = 'wager_questions';
    protected $fillable = ['game_id', 'question', 'starts_at', 'week'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function options()
    {
    return $this->hasMany(WagerOption::class, 'game_id', 'game_id')->pluck('option');
    }

    public function gameoptions()
    {
    return $this->hasMany(WagerOption::class, 'game_id', 'game_id');
    }

    /*
    public function teaminfo()
    {
    return $this->options()
    }
*/

    public function results()
    {
    return $this->hasOne(WagerResults::class, 'game', 'game_id');
    }

    public function bettors()
    {
    return $this->hasMany(Wager::class, 'gameid', 'game_id');
    }
    
    
}
