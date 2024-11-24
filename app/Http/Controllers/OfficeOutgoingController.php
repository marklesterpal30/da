<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Document;
use App\Models\Purpose;

class OfficeOutgoingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $incomingCountOffice = Document::where('status', 'pending')
        ->where('recieved_by', $userId)
        ->count();

        $purposes = Purpose::all()->where('purpose_type', 'outgoing');
        return view('office.outgoing.outgoing', compact(
            'purposes',
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
        $senderId = Auth::id();
        $input = $request->all();

        $filename = $request->input('file_name');
        $fileExtension = $request->file('file')->getClientOriginalExtension();
        $filename = $filename . '.' . $fileExtension;
        $filePath = $request->file('file')->storeAs('files', $filename, 'public');

        $input['address_from'] = Auth::user()->email;
        $input['outgoing_email'] = $request->input('forward_to');
        $input['file'] = $filename;
        $input['sender_id'] = $senderId;
        $input['status'] = "pending";
        $input['sended_date'] = now();
        $input['recieved_by'] = 2;
        $input['type'] = 'outgoing';
        $input['category'] = '';
        $input['description'] =  '';
        Document::create($input);

        

        return redirect('/office-outgoing')->with('success', 'Sucessfully sent your document.');
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
