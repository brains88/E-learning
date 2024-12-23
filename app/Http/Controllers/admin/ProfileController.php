<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\{User,investment,plan,wallet,Deposit,Referral};
use Storage;
class ProfileController extends Controller
{
    //

    public function index()
    {
        $userData = auth()->user();
    
        return view('admin.profile', compact('userData'));
    }


    public function updateProfile(Request $request)
{
    $user = auth()->user(); // Get the currently authenticated user

    // Validate the incoming request data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'country' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:8|confirmed',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Update user information
    $user->name = $request->name;
    $user->email = $request->email;
    $user->country = $request->country;

    // Handle password update (if provided)
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    // Handle image upload and deletion of the previous image
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        // Delete the old image if it exists
        if ($user->image && Storage::exists('public/profile_images/' . $user->image)) {
            Storage::delete('public/profile_images/' . $user->image);
        }
    
        // Save the new image with a unique name
        $imageName = time() . '.' . $request->file('image')->extension();
        $request->file('image')->storeAs('profile_images', $imageName, 'public');
    
        // Store the filename in the database (not the full path)
        $user->image = $imageName;
    }
    
    
    // Save the updated user data
    $user->save();

    // Flash a success message to the session
    session()->flash('success', 'Profile updated successfully!');

    // Redirect to the profile page with the success message
    return redirect()->route('admin.profile');
}

    


}
