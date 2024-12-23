<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Course, Quiz, Progress, Lesson};
class CoursesController extends Controller
{
    //
    public function index()
    {
        // Get the logged-in user
        $user = auth()->user();
    
        // Retrieve course IDs from lessons
        $courseIds = $user->lessons->pluck('course_id');
    
        // Retrieve courses based on the IDs
        $courses = Course::whereIn('id', $courseIds)->get();
    
        return view('user.my-courses', compact('user', 'courses'));
    }
    
    //Show Course Detail
    public function show($id)
    {
        $course = Course::findOrFail($id);
    
        return response()->json([
            'title' => $course->title,
            'description' => $course->description,
            'video' => $course->video,
            // Add more details if needed
        ]);
    }
    

//To Continue Learning
    public function learn($id)
{
    $course = Course::findOrFail($id);
    $lessons = Lesson::where('course_id', $id)->get();

    return view('courses.learn', compact('course', 'lessons'));
}

    
    public function Courses()
    {
      return view('user.courses');
    }
}
