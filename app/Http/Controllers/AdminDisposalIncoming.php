<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use Carbon\Carbon;

class AdminDisposalIncoming extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        $months = $request->input('months');
        $weeks = $request->input('weeks');
        
        // Default query to retrieve all documents
        $query = Document::query();
    
        if ($category) {
            // Add category filter to the query
            $query->where('category', $category);
        }
    
        if ($months) {
            // Assuming $months is in the format "Month Year", e.g., "April 2024"
            $startOfMonth = Carbon::parse($months)->startOfMonth();
            $endOfMonth = Carbon::parse($months)->endOfMonth();
        }
    
        // Retrieve documents based on the constructed query
        $files = $query->where('type', 'incoming')
        ->where('inactive_years', '<', now())->get();

        return view('admin.disposalincoming.index', [
            'files' => $files,
            'selectedCategory' => $category,
            'selectedMonth' => $months,
            'selectedWeek' => $weeks,
        ]);
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
        Document::destroy($id);
        return redirect('/admin-disposalincoming');
    }
}
