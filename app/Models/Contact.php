<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = ['user_id', 'subject', 'message', 'contact_email'];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
}
