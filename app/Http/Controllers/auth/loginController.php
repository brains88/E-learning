<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{


    public function index()
    {
      return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Get the credentials from the request
        $credentials = $request->only('email', 'password');
    
        // Attempt to log in the user with the provided credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();  // Get the authenticated user
    
            // Check the role of the authenticated user
            switch ($user->role) {
                case 'admin':
                    $redirectUrl = route('admin.dashboard'); // Redirect to admin dashboard
                    break;
    
                case 'teacher':
                    $redirectUrl = route('teacher.dashboard'); // Redirect to teacher dashboard
                    break;
    
                case 'student':
                    $redirectUrl = route('user.dashboard'); // Redirect to student dashboard
                    break;

    
                default:
                    $redirectUrl = route('home'); // Default redirection if no role is matched
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => $redirectUrl  // Redirect based on user role
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials. Please try again.'
            ], 400);
        }
    }
    
    
    
      // Logout method
      public function logout(Request $request)
      {
          auth()->logout();
      
          $request->session()->invalidate();
          $request->session()->regenerateToken();
      
          return redirect('/'); // Redirect to the home page
      }
      
}