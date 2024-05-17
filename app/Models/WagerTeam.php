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

    public function options()
    {
    return $this->hasMany(WagerOption::class, 'question');
    }
}
