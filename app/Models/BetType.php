<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetType extends Model
{
    use HasFactory;

    protected $table = 'bet_types';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $guarded = [];
}
