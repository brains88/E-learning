<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Course, Quiz, Progress, course_user,Lesson,questions,Answer };
use Illuminate\Support\Facades\Log;
class QuizzesController extends Controller
{
    //
    public function index()
  {
    $userId = auth()->id();
    $user=auth()->user();
    
    // Fetch courses with quizzes that the user is enrolled in
    $courses = Course::whereHas('lessons', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })->with(['questions'])->get();

    return view('admin.quiz', compact('courses', 'user'));
  }

  public function submitAnswer(Request $request, $courseId)
  {
      Log::info("Submit quiz for course ID: $courseId");
  
      // Validate request data
      $validatedData = $request->validate([
          'answers' => 'required|array', // Ensure it's an array
          'answers.*' => 'required|string', // Ensure each answer is a string
          'selected_option' => 'nullable|string',
      ]);
  
      Log::info(json_encode($validatedData));  // Log the validated data
  
      $userId = auth()->id(); // Get logged-in user ID
  
      // Check if the user has already submitted an answer for this course
      $existingAnswer = Answer::where('user_id', $userId)
                              ->where('course_id', $courseId)
                              ->first();
  
      if ($existingAnswer) {
          Log::info("User has already submitted an answer.");
          session()->flash('error', 'You have already submitted an answer for this course.');
          return redirect()->back(); // Redirect back to the form
      }
  
      // Save the answers, including checking if each answer is not null
      foreach ($validatedData['answers'] as $questionId => $answer) {
          if (!empty($answer)) { // Ensure it's not empty
              Answer::create([
                  'course_id' => $courseId,
                  'user_id' => $userId,
                  'answer' => $answer, 
                  'selected_option' => $validatedData['selected_option'] ?? null,
              ]);
          } else {
              Log::warning("Answer is missing for question ID " . $questionId);
          }
      }
  
      Log::info("Answers submitted successfully for course $courseId");
  
      // Returning a success message as part of the session
      session()->flash('success', 'Answers submitted successfully.');
  
      return redirect()->back(); // Redirect back to the form
  }
  
  

  
  
}
