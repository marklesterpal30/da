<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Document;
use App\Models\ForwardedDocument;
use App\Models\DocumentHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Purpose;



class OfficeAllDocumentsController extends Controller
{

    public function forwardDocuments(Request $request){
        $userId = Auth::id();

        $document = Document::where('id', $request->input('document'));
        $documenthistory = DocumentHistory::where('file', $request->input('documentname'));

         $document->update([
            'forwareded_to' => 3,
            'forwareded_by' => $userId,
            'status' => "forwarded",
        ]);

        $documenthistory->update([
            'forwareded_to' => 3,
            'forwareded_by' => $userId,
            'forwarded_date' => now(),
        ]);

        return redirect('/distributor-alldocuments');  
    }


    public function index(Request $request)
    {
        $userId = Auth::user()->id;
 
        $outgoingDocuments = Document::where('sender_id', $userId)
        ->simplePaginate(5);

       $incomingDocuments = Document::whereIn('id', ForwardedDocument::where('forwarded_to', $userId)
        ->whereNotNull('accepted_date')
        ->pluck('document_id'))
        ->simplePaginate(5);
        
        return view('office.alldocuments.index', compact(
            'outgoingDocuments',
            'incomingDocuments'
        ));
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $file = Document::find($id);
        $forwardedDocument = ForwardedDocument::where('document_id', $file->id)->get();

        return view('office.alldocuments.edit', compact(
            'file',
            'forwardedDocument'
        ));
    }

    public function update(Request $request, string $id)
    {
       //
    }

    public function destroy(string $id)
    {
        //
    }
}
