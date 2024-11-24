<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showlogin(){
        return view('login.login');
    }   

    public function login(Request $request){
        // Attempt to authenticate the user
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Redirect based on the user role
        if ($user->role == 'user') {
            return redirect()->intended('/user-dashboard');
        } elseif ($user->role == 'admin') {
            return redirect()->intended('/admin-dashboard');
        } else {
            return redirect()->intended('/office-dashboard');
        }
    }

    // Authentication failed, return to login with an error message
    return redirect('/login')->withErrors(['credentials' => 'Invalid email or password.']);
}
    
 

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
