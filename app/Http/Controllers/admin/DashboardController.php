<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\{User, Course, Quiz, Progress, course_user,Lesson,Question,Message};
use Str;
use Auth;
class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user

        // Fetch the student's data
        $users = User::where('role', 'student')->count();
        $courses = Course::count();
        $questions = Question::count();
        $messages = Message::count(); // Assuming there's a 'hours_studied' field in the Progress model

        return view('admin.dashboard', compact('user', 'users', 'courses', 'questions','messages'));
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
