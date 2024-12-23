<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Log; // Add Log facade

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        try {
            // Validate the request
            $request->validate(['email' => 'required|email']);
    
            Log::info('Password reset request received for email: ' . $request->email);
    
            // Check if the email already exists in the password_resets table
            PasswordReset::where('email', $request->email)->delete(); // Delete any existing entry for the email
    
            // Generate a unique token
            $token = Str::random(60);
    
            // Store the token and its expiration time in the password_resets table
            $expiration = Carbon::now()->addHour(); // Set expiration time to 1 hour from now
            PasswordReset::create([
                'email' => $request->email,
                'token' => $token,
                'expires_at' => $expiration,
            ]);
    
            Log::info('Password reset token generated for email: ' . $request->email);
    
            // Send the password reset email
            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));
    
            Log::info('Password reset email sent to: ' . $request->email);
    
            return response()->json(['message' => 'An email has been sent.'], 200);
        } catch (\Exception $e) {
            Log::error('Error in sendResetLinkEmail: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while sending the reset email.'], 500);
        }
    }
    

    public function resetPassword(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'token' => 'required|string',
                'password' => 'required|min:8|confirmed',
            ]);

            Log::info('Password reset attempt with token: ' . $request->token);

            // Find the password reset entry by token and check its validity
            $passwordReset = PasswordReset::where('token', $request->token)
                ->where('expires_at', '>', Carbon::now()) // Ensure token hasn't expired
                ->first();

            if (!$passwordReset) {
                Log::warning('Invalid or expired token: ' . $request->token);
                return response()->json(['message' => 'Password reset token invalid or expired.'], 400);
            }

            // Find the user by email
            $user = User::where('email', $passwordReset->email)->first();

            if (!$user) {
                Log::warning('User not found for email: ' . $passwordReset->email);
                return response()->json(['message' => 'User not found.'], 404);
            }

            // Update user's password
            $user->password = Hash::make($request->password);
            $user->save();

            Log::info('Password updated for user: ' . $passwordReset->email);

            // Delete the password reset token from the table
            $passwordReset->delete();

            return response()->json(['message' => 'Password reset successful.'], 200);
        } catch (\Exception $e) {
            Log::error('Error in resetPassword: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while resetting the password.'], 500);
        }
    }
}
