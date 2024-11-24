<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
{
    public function showCreatorProfile(){
        $userId = Auth::id();
        return view('user.profile.index', compact(
            'userId'
        ));
    }

    public function changePassword(Request $request) {
        $userId = $request->input('userId');
        $currentPassword = $request->input('currentPassword');
        $newPassword = $request->input('newPassword');
    
        $user = User::find($userId);
    
        // Check if the user exists
        if (!$user) {
            return redirect('/user-profile')->with('error', 'User not found.');
        }
    
        // Verify the current password against the stored password
        if (!Hash::check($currentPassword, $user->password)) {
            return redirect('/user-profile')->with('error', 'Current password is incorrect.');
        }
    
        // Update the password
        $user->update([
            'password' => Hash::make($newPassword) // Hash the new password before saving
        ]);
    
        return redirect('/user-profile')->with('success', 'Successfully changed password.');
    }
    
}
