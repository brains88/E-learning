<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User};
use Auth;
use Illuminate\Support\Facades\Log;
class AuthCheckController extends Controller
{
  // Check if the user is authenticated
        public function verify()
        {
            if (auth()->check()) {
                return response()->json([
                    'authenticated' => true,
                    'user' => auth()->user()
                ]);
            }
        
            return response()->json(['authenticated' => false], 401);
        }
        

    public function checkAdmin()
    {
        // Check if the authenticated user is an admin
        $isAdmin = auth()->check() && (auth()->user()->role === 'admin');
        
        return response()->json(['isAdmin' => $isAdmin]);
    }
    
    public function checkUser()
    {
        // Check if the authenticated user is a user
        $isuser = auth()->check() && auth()->user()->role === 'user';
        
        return response()->json(['isUser' => $isUser]);
    }
}