<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/* This site runs for a season, when every record counts why risk it? Only allow users that want to be deleted to this model. After the season, they can be wiped.. */
class DeleteUser extends Model
{
    use HasFactory;

    protected $table = 'pending_deletions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}