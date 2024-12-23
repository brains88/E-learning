<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
   
 // Display messages
    public function index()
    {
        $messages= Message::where('user_id', Auth::id()) // Fetch messages for the logged-in user
        ->orderBy('created_at', 'asc')
        ->get();
    
        return view('user.messages', compact('messages'));
    }
    

    // Store a new message
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
    
        $message = Message::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => $message->message,
        ]);
    }

    // Reply to a message (admin functionality)
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'user_id' => $id, // User ID to whom the admin replies
            'message' => $request->message,
            'is_admin_reply' => true,
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }
}

