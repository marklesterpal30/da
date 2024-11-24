<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Document;

class AdminCreteDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.outgoing.createdocuments');
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
        $senderId = Auth::id();
        $input = $request->all();
        
        // Get the file from the request
        $file = $request->file('file');
        
        // Get the file name and extension
        $filename = $request->input('file_name');
        $fileExtension = $file->getClientOriginalExtension();
        $filename = $filename . '.' . $fileExtension;
        
        // Store the file in the public directory
        $filePath = Storage::disk('public')->putFileAs('files', $file, $filename);
        
        // Extract category from request
        $category = $request->input('category');
        
        // Retrieve the last document based on the category
        $lastDocument = Document::where('category', $category)
            ->latest('updated_at')
            ->whereNotNull('code')
            ->first();
        
        $lastCode = null;
        if ($lastDocument) {
            $lastCode = $lastDocument->code;
        }
        
        // Update the input array with additional data
        $input['file'] = $filename;
        $input['sender_id'] = $senderId;
        $input['status'] = 'pending';
        $input['sended_date'] = now();
        $input['recieved_by'] = 2;
        $input['type'] = 'outgoing';
        $input['lastcode'] = $lastCode;
        $input['category'] =  '';
        
        // Create a new document record
        Document::create($input);
        
        return redirect('/admin-outgoing-documents')->with('success', 'Sucessfully uplaod your document.');
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
