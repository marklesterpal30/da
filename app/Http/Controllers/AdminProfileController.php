<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Document;
use Illuminate\Support\Facades\Hash; // Import Hash facade



class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        return view('admin.profile.index', compact(
            'userId'    
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //update the user Profile
    public function store(Request $request)
    {
      
    
        $user = User::findOrFail($request->input('userId'));
        $oldEmail = $user->email;
    
        // Assign new values, defaulting to the existing values if not provided
        $newEmail = $request->input('email', $oldEmail);
        $newName = $request->input('name', $user->name);
    
        // Update documents that have the old email address
        if ($newEmail !== $oldEmail) {
            Document::where('address_from', $oldEmail)
                ->update(['address_from' => $newEmail]);
        }
    
        // Update the user's profile information
        $user->update([
            'name' => $newName,
            'email' => $newEmail,
        ]);
    
        // Handle password update if current and new passwords are provided
        if ($request->filled('currentPassword') && $request->filled('newPassword')) {
            if (!Hash::check($request->input('currentPassword'), $user->password)) {
                return redirect('/user-profile')->with('error', 'Current password is incorrect.');
            }
    
            // Update the password
            $user->update([
                'password' => Hash::make($request->input('newPassword')), // Hash the new password before saving
            ]);
        }
    
        return redirect('/admin-profile')->with('success', 'Successfully updated profile.');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
