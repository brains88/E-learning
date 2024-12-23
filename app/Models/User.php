<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; 

class User extends Authenticatable
{
    //
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password','country', 'image', 'role'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }
    


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }


            public function answers()
        {
            return $this->hasMany(Answer::class);
        }

        public function messages()
        {
            return $this->hasMany(Message::class);
        }
}



