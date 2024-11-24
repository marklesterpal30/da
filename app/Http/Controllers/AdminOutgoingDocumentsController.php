<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\ForwardedDocument;
use App\Models\Purpose;
use App\Models\User;
use Illuminate\Support\Facades\DB;




class AdminOutgoingDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $userId = Auth::id();
        $types = Purpose::where('purpose_type', 'outgoing')->get();
        $files = Document::where('sender_id', $userId)->where('status', 'pending')->get();
        $users = User::whereIn('role', ['user', 'office'])
        ->orderByRaw("FIELD(role, 'office', 'user') ASC")
        ->get();
    
       return view('admin.outgoing.outgoingdocuments', compact(
        'types',
        'files',
        'users'
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
    //PUBLIC FUNCITON OUTGOINGFORWARD DOCUMENTS
    public function store(Request $request)
    {
        $userId = Auth::id();
        $file = Document::find($request->input('id'));
        $forwardTo = $request->input('forwardTo'); // expecting an array of office IDs
        $active_years = $request->input('active_years');
        $inactive_years = $request->input('inactive_years');

        foreach ($forwardTo as $receiverId) {
            DB::table('forwarded_documents')->insert([
                'document_id' => $file->id,
                'forwarded_to' => $receiverId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        $file->update([
            'code' => $request->input('reference_code'),
            'category' => $request->input('category'),
            'location' => $request->input('location'),
            'active_years' => now()->addYear($active_years) ,
            'inactive_years' => now()->addYear($active_years + $inactive_years),
            'fowarded_by' => $userId,
            'fowarded_date' => now(),
            'status' => 'forwarded',
            'forwarded_data' => now(),
        ]);

        return redirect('/admin-outgoing-documents')->with('success', 'Sucessfully sent your document.');
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


        return view('admin.outgoing.edit', compact(
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
