<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;


class OfficeDashboardController extends Controller
{
    public function showDistributorDashboard(){
     
        $userId = Auth::id();

        $pendingsOutgoing = Document::where('sender_id', $userId)
            ->where('status', 'pending')
            ->count();

        $pendingIncoming = Document::whereHas('forwardedDocuments', function($query) use ($userId){
            $query->where('forwarded_to', $userId)
            ->whereNull('accepted_date');
        })->count();

        $pendingsCount = $pendingsOutgoing + $pendingIncoming;

        $receivedCounts = Document::where('sender_id', $userId)
            ->where('status', 'received')
            ->count();

        $forwardedCounts = Document::where('sender_id', $userId)
            ->where('status', 'forwarded')
            ->count();

        $acceptedCounts =  Document::whereHas('forwardedDocuments', function($query) use ($userId){
            $query->where('forwarded_to', $userId)
            ->whereNotNull('accepted_date');
        })->count();

        $documentsCountByMonth = Document::where('sender_id', $userId)
        ->orWhereHas('forwardedDocuments', function($query) use ($userId) {
            $query->where('forwarded_to', $userId);
        })
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->get();

        $months = [];
        $counts = [];

        // Fill arrays with counts for each month
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
            $document = $documentsCountByMonth->firstWhere('month', $i);
            $counts[] = $document ? $document->count : 0;
        }

        $documentsCountByCategory = Document::where('sender_id', $userId)
        ->orWhereHas('forwardedDocuments', function($query) use ($userId) {
            $query->where('forwarded_to', $userId);
        })
        ->selectRaw('category, COUNT(*) as count') // Assuming 'category' is a field in your Document model
        ->groupBy('category')
        ->get();

    $categories = $documentsCountByCategory->pluck('category');
    $countscategories = $documentsCountByCategory->pluck('count');

        return view('office.dashboard.index', compact(
            'pendingsCount',
            'receivedCounts',
            'forwardedCounts',
            'acceptedCounts',
            'months',
            'counts',
            'categories',
            'countscategories'
        ));
    }
}
