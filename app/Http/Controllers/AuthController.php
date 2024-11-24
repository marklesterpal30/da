<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Hash; // Import Hash facade




class AuthController extends Controller
{
    public function showlogin(){
        return view('auth.login');
    }   
    public function login(Request $request)
    {
        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Check if the user's email is verified
            if (is_null($user->email_verified_at)) {
                // Log out the user if their email is not verified
                Auth::logout();
                return redirect('/login')->with('error', 'Please verify your email before logging in.');
            }
    
            // Redirect based on user role
            if ($user->role == 'user') {
                return redirect()->intended('/user-dashboard')->with('success', 'Welcome back!');
            } elseif ($user->role == 'admin' || $user->role == 'superadmin') {
                return redirect()->intended('/admin-dashboard')->with('success', 'Welcome back!');
            } else {
                return redirect()->intended('/office-dashboard')->with('success', 'Welcome back!');
            }
        }
    
        return redirect('/login')->with('error', 'Invalid email or password.');
    }
    
    public function signupForm(){
        return view('auth.signup');
    }

    public function signup(Request $request) {

        $existingUser = User::where('email', $request->input('email'))->first();
        
        if ($existingUser) {
            $request->session()->flash('error', 'The email is already used.');
            return redirect()->back()->withInput();
        }
            $input = $request->all();
        
            try {
                User::create($input);
        
                $recipient = $request->input('email');
                $message = "Please Verify Your Account";
                $request->session()->flash('email', $recipient);
    
                // Mail::to($recipient)->send(new VerifyMail($message));
        
                return redirect('/login')->with('success', 'Signup successful! Please verify your email.');
        
            } catch (\Exception $e) {
                $request->session()->flash('error', 'Signup failed. Please try again.');
                return redirect()->back()->withInput();
            }
    }

    public function showVerify(){
        return view('auth.verify');
    }

    public function sendVerification(Request $request)
    {
        // Retrieve the email from the request input
        $recipient = $request->input('email');
    
        // Check if the user exists
        $user = User::where('email', $recipient)->first();
    
        // If the user does not exist, redirect back with an error
        if (!$user) {
            return redirect('/verifyForm')->with('error', 'This email is not registered.');
        }
    
        // If the user is already verified, redirect back with an error
        if (!is_null($user->email_verified_at)) {
            return redirect('/verifyForm')->with('error', 'This email is already verified.');
        }
    
        // Attempt to send the verification email
        try {
            $message = "Please Verify Your Account";
            $request->session()->flash('email', $recipient);
    
            // Send the verification email
            Mail::to($recipient)->send(new VerifyMail($message));
    
            // If email sent successfully, redirect to login with a success message
            return redirect('/login')->with('success', 'Check your email to verify your account.');
        } catch (\Exception $e) {
            // Catch any errors and return an error message
            return redirect('/login')->with('error', 'There was an issue sending the email. Please try again later.');
        }
    }
    
    

    public function verify($email){
        $user = User::where('email', $email);
        $user->update([
        'email_verified_at' => now(),
        ]);

        return redirect('/login')->with('success', 'Your account is verified now');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function forgotPasswordForm(){
        return view('auth.forgotpassword');
    }

    public function forgotPassword(Request $request){
        $recipient = $request->input('email');

        $user = User::where('email', $recipient)->first();

        $request->session()->flash('email', $recipient);

        // If the user does not exist, redirect back with an error
        if (!$user) {
            return redirect('/verifyForm')->with('error', 'This email is not registered.');
        }

         try {
            $message = "Please Verify Your Account";

            Mail::to($recipient)->send(new ForgotPassword($message));
    
            return redirect('/forgotpassword')->with('success', 'Check your email to reset your password.');
        } catch (\Exception $e) {
            // Catch any errors and return an error message
            return redirect('/forgotpassword')->with('error', 'There was an issue sending the email. Please try again later.');
        }

    }

    public function resetPasswordForm($email)
    {
        return view('auth.resetPassword', compact('email'));
    }

    public function resetPassword(Request $request){
        $user = User::where('email', $request->input('email'));
        $newPassword = $request->input('newPassword');
        $user->update([
            'password' => Hash::make($request->input('newPassword')) // Hash the new password before saving
        ]);

        return redirect('/login')->with('success', 'Sucessfully change your password');
    }

}
