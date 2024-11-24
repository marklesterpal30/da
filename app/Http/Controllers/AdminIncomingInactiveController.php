<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ForwardedDocument;


class AdminIncomingInactiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function reportInactive($documentId){
        $document = Document::find($documentId);
        return view('admin.inactiveincoming.report', compact('document'));
    }

    public function index()
    {
      
        $atiSpecialOrders = Document::where('category', 'ATI SPECIAL ORDER')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $atiMemorandumOrders = Document::where('category', 'ATI MEMORANDUM ORDER')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $letters = Document::where('category', 'LETTERS')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        // Adding new categories with ordering by most recent
        $others = Document::where('category', 'OTHERS')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $daMemorandumOrders = Document::where('category', 'DA MEMORANDUM ORDER')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $daSpecialOrders = Document::where('category', 'DA SPECIAL ORDER')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $travelOrders = Document::where('category', 'TRAVEL ORDER')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $ob = Document::where('category', 'OB')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $letter = Document::where('category', 'LETTER')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $requestToWork = Document::where('category', 'REQUEST TO WORK')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $trainingDesign = Document::where('category', 'TRAINING DESIGN')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $contract = Document::where('category', 'CONTRACT')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        $officeOrders = Document::where('category', 'OFFICE ORDER')
        ->where('inactive_years', '>' , now())
        ->where('active_years', '<', now())
        ->orderBy('created_at', 'desc')
            ->get();
    
        return view('admin.inactiveincoming.index', compact(
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


        return view('admin.inactiveincoming.edit', compact(
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
