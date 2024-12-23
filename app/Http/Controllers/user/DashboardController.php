<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\{User, Course, Quiz, Progress, course_user,Lesson,Message,Question,Answer};
use Str;
use Auth;
class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user
        // Fetch all the course IDs the user is enrolled in
        $enrolledCourseIds = Lesson::where('user_id', $user->id)->pluck('course_id');
        // Fetch the student's data
        $coursesEnrolled = Lesson::where('user_id', $user->id)->count();
        $totalAnswers = Answer::where('user_id', $user->id)->count();
        $totalQuestions = Question::whereIn('course_id',$enrolledCourseIds)->count();
        $totalMessages = Message::where('user_id', $user->id)->count(); 

        $ongoingCourses= Course::whereIn('id',$enrolledCourseIds)->where('status', 'active')->get();
        return view('user.dashboard', compact('user', 'coursesEnrolled', 'totalAnswers', 'totalQuestions', 'totalMessages', 'ongoingCourses'));
    }


    //User Profile

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }

        // Validate request data
        $request->validate([
            'newPassword' => 'required|string|min:8|confirmed', // Ensure password confirmation is sent as 'password_confirmation'
        ]);

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password updated successfully!',
        ]);
    }

}
