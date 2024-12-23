<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Course, Quiz, Progress, course_user,Lesson,Question,Message};
use Str;
use Auth;

class UserController extends Controller
{
    //

        public function index()
        {
            $students = User::where('role', 'student')->get();
            return view('admin.student', compact('students'));
        }
    
        // Delete a student
        public function destroy($id)
        {
            $student = User::findOrFail($id);
            $student->delete();
            return redirect()->route('admin.students')->with('success', 'Student deleted successfully.');
        }
    
        // View student details
        public function show($id)
        {
            $student = User::with(['lessons', 'answers', 'messages'])->findOrFail($id);
            
            // Fetch unique courses based on lessons
            $courseIds = $student->lessons->pluck('course_id')->unique();
            $courses = Course::whereIn('id', $courseIds)->get();
        
            return view('admin.student-details', compact('student', 'courses'));
        }
        
        

}
