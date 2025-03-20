<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Course, Quiz, Progress,Lesson};
class HomeController extends Controller
{
    //

    public function index()
    {
        $courses = Course::paginate(6); // Fetch courses with pagination (6 per page)
        return view('frontend.home', compact('courses'));
    }
 

}
