<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purpose;

class AdminPurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function deletePurpose(Request $request){
       $purpose_name = $request->input('purpose_name');
  
       Purpose::where('purpose_name', $purpose_name)->delete();
       return redirect('/admin-purpose');
    }


    public function index()
    {
        $purposes = Purpose::all();
        return view('admin.purpose.index', ['purposes' => $purposes]);
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
        $input = $request->all();
        Purpose::create($input);
        return redirect('/admin-purpose');

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
