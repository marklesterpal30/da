<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ForwardedDocument;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AdminRecordsController extends Controller
{
    
    public function index(Request $request)
{

    $datenow = Carbon::now();

    $query = Document::query();

    $files = $query->get()->whereIn('status', ['received', 'forwarded', 'accepted']);

    return view('admin.records.index', [
        'files' => $files,

    ]);
}

public function generateReport(Request $request)
{
    // Get the filter inputs
    $category = $request->input('category');
    $fromMonth = $request->input('fromMonth');
    $toMonth = $request->input('toMonth');

    $query = Document::query();

    if ($category) {
        $query->where('category', $category);
    }

    if ($fromMonth) {
        $query->whereMonth('created_at', '>=', $fromMonth);
    }

    if ($toMonth) {
        $query->whereMonth('created_at', '<=', $toMonth);
    }
    $files = $query->where('sender_id', '!=', 2)
    ->where('status', '!=', 'pending')
    ->get();
    
    return view('admin.records.report', compact('files', 'category', 'fromMonth', 'toMonth'));
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

        return view('admin.records.edit',
         [
          'file' => $file,
          'forwardedDocument' => $forwardedDocument
        ]);
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
