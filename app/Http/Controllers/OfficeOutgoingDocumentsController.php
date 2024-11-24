<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;


class OfficeOutgoingDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $month = $request->input('month');
        $selectedMonth = $request->input('month');
        $userId = Auth::id();
        $query = Document::query();
   
        if ($status) {
            $query->where('sender_id', $userId)
                ->where('status', $status)
                ->get();
        } 

        if($month){
            $query->whereMonth('created_at', $month);
        }

        $files = $query->where('type', 'outgoing')->get();

        $userId = Auth::id();

        $incomingCountOffice = Document::where('status', 'pending')
        ->where('recieved_by', $userId)
        ->count();

        return view('office.outgoing.outgoingdocuments', compact(
            'files',
            'selectedMonth',
            'incomingCountOffice'
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
        $file = Document::find($id);

        return view('office.outgoing.edit', compact(
            'file'
        ));
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
