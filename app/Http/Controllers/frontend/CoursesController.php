<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Course, Quiz, Progress,Lesson};
class CoursesController extends Controller
{
    //
   // Display a listing of the courses with pagination
   public function index()
   {
       $courses = Course::paginate(12); // Fetch courses with pagination (6 per page)
       return view('frontend.courses', compact('courses'));
   }

   // Display course details in a modal
// app/Http/Controllers/CourseController.php

public function show($id)
{
    $course = Course::findOrFail($id);

    return response()->json([
        'title' => $course->title,
        'description' => $course->description,
        // Add more details if needed
    ]);
}


   // Handle course enrollment logic
 public function enroll(Request $request, $courseId)
{
    // Validate the request
    $request->validate([
        'course_id' => 'required|exists:courses,id',
    ]);

    try {
        $userId = auth()->user()->id;

        // Check if the user is already enrolled in the course
        $alreadyEnrolled = Lesson::where('course_id', $request->course_id)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyEnrolled) {
            return response()->json([
                'success' => false,
                'message' => 'You are already enrolled in this course.',
            ], 422); // Unprocessable Entity
        }

        // Save enrollment details in the lessons table
        Lesson::create([
            'course_id' => $request->course_id,
            'user_id' => $userId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully enrolled in the course!',
        ], 200); // OK

    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while enrolling. Please try again later.',
            'error' => $e->getMessage(), // Optional: Include error details for debugging
        ], 500); // Internal Server Error
    }
}

    
}
