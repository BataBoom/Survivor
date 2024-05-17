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

    public function result()
    {
    return $this->hasOne(WagerResult::class, 'game', 'game_id');
    }

    public function wagers()
    {
    return $this->hasMany(Survivor::class, 'game_id', 'game_id');
    }

    public function scopeScheduled($query)
    {
        return $query->where('ended', false)->where('starts_at', '>=', now())->get();
    }
    
    
}
