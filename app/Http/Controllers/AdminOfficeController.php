<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;


class AdminOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = User::where('role', 'office')->get();

        foreach ($offices as $office) {
            // Split the full name into parts
            $parts = explode(' ', $office->name);
            
            // Extract first initial
            $firstNameInitial = substr($parts[0], 0, 1);
            
            // Extract last initial (if available)
            $lastNameInitial = isset($parts[1]) ? substr($parts[1], 0, 1) : '';
            
            // Concatenate initials
            $userAvatar = strtoupper($firstNameInitial . $lastNameInitial);
            
            // Assuming you want to add this as a new attribute to the user object
            $office->user_avatar = $userAvatar;
        }

        return view('admin.office.index', ['offices' => $offices]);
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
    public function store(Request $request)
{
    $input = $request->input();
    $input['password'] = bcrypt($input['password']);
    $input['email_verified_at'] = Carbon::now();
    User::create($input);

    return redirect('/admin-employee');
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
        $user = User::destroy($id);
        return redirect()->back();
    }
}
