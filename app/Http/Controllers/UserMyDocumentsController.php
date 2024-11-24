<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\ForwardedDocument;


class UserMyDocumentsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $userId = Auth::id();
    
        $incomingQuery = Document::query()
        ->join('forwarded_documents', 'documents.id', '=', 'forwarded_documents.document_id')
        ->where('documents.sender_id', '!=', $userId)
        ->whereIn('documents.status', ['received', 'accepted'])
        ->where('forwarded_documents.forwarded_to', $userId)
        ->where('accepted_date', '!=', null)
        ->orderBy('documents.created_at', 'desc')
        ->select('documents.*'); // Select all fields from documents table
    
    
        // Query for outgoing documents
        $outgoingQuery = Document::query()
            ->where('sender_id', $userId);    
        // Filter by status if provided
        if ($status) {
            $incomingQuery->where('status', $status);
            $outgoingQuery->where('status', $status);
        }
    
        // Paginate incoming and outgoing documents
        $incomingFiles = $incomingQuery->simplePaginate(5); // Use pagination instead of get()
        $outgoingFiles = $outgoingQuery->orderBy('created_at', 'desc')->simplePaginate(5);
    
        // Count accepted and forwarded documents for incoming files
        foreach ($incomingFiles as $file) {
            $countOfAcceptedDocuments = ForwardedDocument::where('document_id', $file->id)
                ->whereNotNull('accepted_date')
                ->where('accepted_date', '!=', '')
                ->count();
    
            $totalForwardedCount = ForwardedDocument::where('document_id', $file->id)->count();
    
            $file->accepted_count = $countOfAcceptedDocuments;
            $file->forwarded_count = $totalForwardedCount;
        }
    
        // Count accepted and forwarded documents for outgoing files
        foreach ($outgoingFiles as $file) {
            $countOfAcceptedDocuments = ForwardedDocument::where('document_id', $file->id)
                ->whereNotNull('accepted_date')
                ->where('accepted_date', '!=', '')
                ->count();
    
            $totalForwardedCount = ForwardedDocument::where('document_id', $file->id)->count();
    
            $file->accepted_count = $countOfAcceptedDocuments;
            $file->forwarded_count = $totalForwardedCount;
        }
    
        // Return the view with both incoming and outgoing files
        return view('user.mydocuments.mydocuments', compact('incomingFiles', 'outgoingFiles'));
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

        return view('user.mydocuments.edit', compact(
            'file',
            'forwardedDocument',
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
