<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;


class DistributorMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipient_id = Auth::id();
        $incomingCount = Document::where('recipient_id', $recipient_id)
                                 ->where('status', 'pending')
                                 ->count();

        return view('distributor.layouts.master', ['incomingCount'=> $incomingCount]);
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
        //
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
