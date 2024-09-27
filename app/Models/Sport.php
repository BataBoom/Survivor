<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;

    protected $table = 'sports';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public $guarded = [];
}
