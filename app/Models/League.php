<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $table = 'leagues';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public $guarded = [];

    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    public function teams()
    {
        return $this->hasMany(WagerTeam::class, 'league_id', 'id');
    }
}
