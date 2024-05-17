<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
   use HasFactory;
    protected $table = 'surveys';

    protected $guarded = [];

    protected $casts = [];

    public $timestamps = true;

    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
}
