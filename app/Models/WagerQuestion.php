<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WagerQuestion extends Model
{
    use HasFactory;
    protected $table = 'wager_questions';
    protected $fillable = ['game_id', 'question', 'starts_at', 'week'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $casts = [
        'starts_at' => 'datetime',
        //'ended' => 'boolean',
    ];

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
    return $this->belongsTo(WagerResult::class, 'game_id', 'game');
    }

    public function wagers()
    {
    return $this->hasMany(Survivor::class, 'game_id', 'game_id');
    }

    public function scopeScheduled($query)
    {
        return $query->where('ended', false)->where('starts_at', '>=', now())->get();
    }

    public function getBeginsAttribute()
    {
        return $this->starts_at->setTimezone('America/New_York');
    }

    /* Added Mid Season for Stats/etc */
    public function teams()
    {
        return $this->gameoptions->each(function ($item) {
            return $item->team;
        });
    }
    
    
}
