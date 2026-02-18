<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizOption extends Model
{
    use HasFactory;

    protected $table = 'quiz_options';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

}
