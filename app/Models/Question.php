<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'question_text', 'options', 'correct_answer'];

    // Define the inverse relationship with the Course model
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}

