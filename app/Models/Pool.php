<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pool extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'survivor_pools';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    public function survivors()
    {
    return $this->belongsTo(SurvivorRegistration::class, 'pool_id');
    }

    



}
