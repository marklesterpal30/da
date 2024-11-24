<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ForwardedDocument;  
use App\Models\DocumentHistory;
use Illuminate\Support\Facades\Auth;

class AdminAllDocumentsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
      
        $atiSpecialOrders = Document::where('category', 'ATI SPECIAL ORDER')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $atiMemorandumOrders = Document::where('category', 'ATI MEMORANDUM ORDER')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $letters = Document::where('category', 'LETTERS')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Adding new categories with ordering by most recent
        $others = Document::where('category', 'OTHERS')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $daMemorandumOrders = Document::where('category', 'DA MEMORANDUM ORDER')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $daSpecialOrders = Document::where('category', 'DA SPECIAL ORDER')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $travelOrders = Document::where('category', 'TRAVEL ORDER')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $ob = Document::where('category', 'OB')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $letter = Document::where('category', 'LETTER')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $requestToWork = Document::where('category', 'REQUEST TO WORK')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $trainingDesign = Document::where('category', 'TRAINING DESIGN')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $contract = Document::where('category', 'CONTRACT')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        $officeOrders = Document::where('category', 'OFFICE ORDER')
            ->where('active_years', '>', now())
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('admin.alldocuments.index', compact(
            'atiSpecialOrders', 
            'atiMemorandumOrders', 
            'letters', 
            'others', 
            'daMemorandumOrders', 
            'daSpecialOrders', 
            'travelOrders', 
            'ob', 
            'letter', 
            'requestToWork', 
            'trainingDesign', 
            'contract', 
            'officeOrders'
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


        return view('admin.alldocuments.edit', compact(
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
