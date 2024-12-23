<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Course, Quiz, Progress, Lesson,Question};
class CoursesController extends Controller
{
    //
    public function index()
    {
        $courses = Course::latest()->get(); // Fetch all courses, ordered by the latest
        return view('admin.tutorials', compact('courses'));
    }
    
    
    // Store a new course in the database
    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'course_image' => 'nullable|image|max:2048',
        'video' => 'nullable|file|mimes:mp4,mkv,avi|max:50000',
        'status' => 'required|in:active,paused',
        'question' => 'nullable|string', // Question text
        'answer' => 'nullable|string', // Answer text
        'options' => 'nullable|array', // Options as an array
    ]);

    // Store course
    $course = new Course($request->only(['title', 'description','status']));

    if ($request->hasFile('course_image')) {
        $course->course_image = $request->file('course_image')->store('courses/images', 'public');
    }

    if ($request->hasFile('video')) {
        $course->video = $request->file('video')->store('courses/videos', 'public');
    }

    $course->save();

    // Store question if available
    if ($request->has('question') && $request->has('answer')) {
        $question = new Question([
            'course_id' => $course->id, // Link to the course
            'question_text' => $request->input('question'),
            'options' => json_encode($request->input('options', [])), // Options as JSON array
            'correct_answer' => $request->input('answer'),
            'status' => 'active', // Default status
        ]);
        $question->save();
    }

    return redirect()->route('admin.tutorials')->with('success', 'Course created successfully.');
}


    // Update a course in the database
    public function update(Request $request, Course $course)
    {
        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_image' => 'nullable|image|max:2048',
            'video' => 'nullable|file|mimes:mp4,mkv,avi|max:50000',
            'status' => 'required|in:active,paused',
            'question' => 'nullable|string', // Question text
            'answer' => 'nullable|string', // Answer text
            'options' => 'nullable|array', // Options as an array
        ]);
    
        // Update course
        $course->update($request->only(['title', 'description', 'status']));
    
        if ($request->hasFile('course_image')) {
            $course->course_image = $request->file('course_image')->store('courses/images', 'public');
        }
    
        if ($request->hasFile('video')) {
            $course->video = $request->file('video')->store('courses/videos', 'public');
        }
    
        // Update or create the question if available
        if ($request->has('question') && $request->has('answer')) {
            // Fetch the first question or create a new one
            $question = $course->questions()->first() ?? new Question([
                'course_id' => $course->id, // Link to the course
                'status' => 'active', // Default status
            ]);

            $question->question_text = $request->input('question');
            $question->options = json_encode($request->input('options', [])); // Options as JSON array
            $question->correct_answer = $request->input('answer');
            $question->save();
        }

    
        return redirect()->route('admin.tutorials')->with('success', 'Course updated successfully.');
    }
    
    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.tutorials')->with('success', 'Course deleted successfully.');
    }

}
