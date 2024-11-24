<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purpose;
use App\Models\Document;

class AdminOutgoingInactiveDocuments extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $month = $request->input('month');
        $selectedType = $request->input('type');
        $types = Purpose::where('purpose_type', 'outgoing')->get();
        $query = Document::query();

        if($month){
            $query->whereMonth('created_at', $month);
        }

        if($selectedType){
            $query->where('category', $selectedType);
        }

        $files = $query->where('type', 'outgoing')
        ->where('active_years', '<', now())
        ->whereIn('status', ['received', 'forwarded'])
        ->get();

        return view('admin.outgoing.inactivedocuments', compact(
            'files', 
            'types',

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
