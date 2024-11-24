<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ForwardedDocument;
use Illuminate\Support\Facades\Auth;


class UserIncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $userId = Auth::id();
    
    $files = ForwardedDocument::query()   // Optional to explicitly call query()
    ->where('forwarded_to', $userId)
    ->whereNull('accepted_date')   // Correct syntax for checking if 'accepted_date' is not null
    ->get();


    return view('user.incoming.index', compact('files'));
}

    
    
    
    
public function received(Request $request) {
    $userId = Auth::id();
    $documentId = $request->input('id');


    // Find the document by ID
    $document = Document::where('id', $documentId)->first();

    if ($document) {
        // Update the document status
        $document->update([
            'status' => 'received',
        ]);
    }

    // Find the forwarded document for this user
    $forwardedDocument = ForwardedDocument::where('document_id', $documentId)
        ->where('forwarded_to', $userId)
        ->first();

    if ($forwardedDocument) {
        // Update the forwarded document
        $forwardedDocument->update([
            'accepted_by' => $userId,
            'accepted_date' => now(),
        ]);
    }

    // Redirect back
    return redirect('/user-incoming')->with('success', 'Sucessfully received the document');
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
        $forwardedDocument = ForwardedDocument::where('document_id', $file->id)->get();


        return view('user.incoming.edit', compact(
            'file',
            'forwardedDocument'
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
