<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Str;

class RegisterController extends Controller
{

    public function index()
    {
      return view('auth.register');
    }
  
    
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:confirm_password',
            'country' => 'required|string|max:100',
            'profile_image' => 'required|image|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(), // Return all validation errors
            ], 400);
        }
    
        // Only process files if validation passes
        try {
            // Ensure the profile_image exists and is a valid file
            if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
                // Save the new image with a unique name
                $imageName = time() . '.' . $request->file('profile_image')->extension();
                $request->file('profile_image')->storeAs('profile_images', $imageName, 'public');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid image file.',
                ], 400);
            }
    
            // Create the user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country' => $request->country,
                'image' => $imageName, // Store the image file name
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully!',
                'redirect' => route('login') // Provide the redirect URL for the frontend
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create account. Please try again.',
            ], 500);
        }
    }
    
    
}