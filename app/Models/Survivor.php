<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Survivor extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'survivor';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected $guarded = [];

    protected $casts = [];

    public function user()
    {
    return $this->belongsTo(User::class, 'user_id', 'id');
    }

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

    public function result()
    {
        return $this->hasOne(WagerResult::class, 'game', 'game_id');
    }

}
