<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Course, Quiz, Progress, course_user,Lesson,Question,Message};
use Str;
use Auth;

class MessageController extends Controller
{
   
 // Display messages
 public function index()
 {
     $students = User::with(['messages' => function ($query) {
         $query->orderBy('created_at', 'asc');
     }])
     ->where('role', 'student') // Assuming students have a 'role' column
     ->get();
 
     return view('admin.messages', compact('students'));
 }
 

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);
    
        // Find the specific message by ID
        $message = Message::findOrFail($id);
    
        // Update the reply and mark it as an admin reply
        $message->reply = $request->input('reply');
        $message->is_admin_reply = true;
        $message->admin_id = auth()->id(); // Assuming admin authentication
        $message->save();
    
        return redirect()->back()->with('success', 'Reply sent successfully!');
    }
    
    
}

