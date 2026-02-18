<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $table = 'quiz_questions';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function options()
    {
        return $this->hasMany(QuizOption::class, 'question_id', 'id')->orderBy('option', 'asc');
    }

    public function answer()
    {
        return $this->hasOne(QuizOption::class, 'question_id', 'id')->where('answer', true);
    }
}
