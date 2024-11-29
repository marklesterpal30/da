<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Mail\AcceptMail;
use Illuminate\Support\Facades\Mail;
use App\Models\ForwardedDocument;





class OfficeIncomingController extends Controller
{

    public function acceptDocuments(Request $request){
        $userId = Auth::id();
        $file = Document::find($request->input('id'));

        $forwardedDocument = ForwardedDocument::where('document_id', $request->input('id'))
                         ->where('forwarded_to', $userId)
                         ->first();


        $forwardedDocument->update([
          'accepted_by' => $userId,
          'accepted_date' => now(),
        ]);

        if ($file->sender_id === 2) { // Use an integer here, not a string
            $file->update([
                'status' => 'received'
            ]);
            $office = Auth::user()->name;
            $message = "The Agricultural Training Institute $office successfully received your document.";
            Mail::to($file->address_from)->send(new AcceptMail($message));
            
        } else {
            $file->update([
                'status' => 'accepted' // You can change this to any other status
            ]);
            $office = Auth::user()->name;

            $message = "The Agricultural Training Institute $office successfully received your document.";
            Mail::to($file->address_from)->send(new AcceptMail($message));
            
        }

       
        // Mail::to($sendto)->send(new AcceptMail($messageContent));
        
        return redirect('/office-incoming')->with('success', 'Sucessfully received document.');   
    }

    public function returnDocuments(Request $request){
        $userId = Auth::id();

        $documentid = $request->input('id');
        $documentfilename = $request->input('file_name');

        DB::table('document_histories')
        ->where('file', $documentfilename)
        ->update([
            'return_by' => $userId,
            'return_date' => now(),
        ]);

        $document = Document::find($documentid);    
        $document->update(['status' => 'return']);

        
        $files = Document::where('recipient_id', $userId)
                         ->where('status', 'pending')
                         ->get();
        
        return redirect('/distributor-incoming');   
    }

    public function index()
    {
       $userId = Auth::id();

       $incomingCountOffice = Document::where('status', 'pending')
       ->where('recieved_by', $userId)
       ->count();
       
       $files = ForwardedDocument::where('forwarded_to', $userId)
       ->whereNull('accepted_date')
       ->get();

       return view('office.incoming.index', compact(
        'files',
        'incomingCountOffice'
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

        return view('office.incoming.edit', compact(
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
