<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'course_image', 'video','status'];  // Ensure 'status' exists


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

     // Define the many-to-many relationship with User
     public function users()
     {
         return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
     }
     
     public function questions()
     {
         return $this->hasMany(Question::class);
     }

}
