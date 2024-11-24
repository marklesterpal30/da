<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ForwardedDocument;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UserDashboardController extends Controller
{
    public function showCreatorDashboard()
    {
        $authUserId = auth()->id(); 
    
        // Count pending documents sent by the authenticated user
        $pendingDocumentsCount = Document::where('sender_id', $authUserId)
            ->where('status', 'pending')
            ->count();
    
        // Count documents forwarded to the authenticated user that are still pending acceptance
        $documentForwardedCount = Document::whereHas('forwardedDocuments', function ($query) use ($authUserId) {
            $query->where('forwarded_to', $authUserId)
                  ->whereNull('accepted_date');
        })->count();
    
        // Total pending count
        $pendingsCount = $pendingDocumentsCount + $documentForwardedCount;
    
        // Count incoming and outgoing received documents
        $incomingReceivedCounts = Document::whereHas('forwardedDocuments', function ($query) use ($authUserId) {
            $query->where('forwarded_to', $authUserId)
                  ->whereNotNull('accepted_date');
        })->count();
    
        $outgoingReceivedCounts = Document::where('sender_id', $authUserId)
            ->where('status', 'received')->count();
    
        $receivedCounts = $incomingReceivedCounts + $outgoingReceivedCounts;
    
        // Count forwarded and accepted documents
        $forwardedCounts = Document::where('sender_id', $authUserId)
            ->where('status', 'forwarded')->count();
    
        $acceptedCounts = Document::where('sender_id', $authUserId)
            ->whereHas('forwardedDocuments', function($query) {
                $query->whereNotNull('accepted_date');
            })->count();
    
        // Combine outgoing and incoming documents, group by year and month
        $documentsByMonth = Document::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('sender_id', $authUserId) // Outgoing documents
            ->orWhereHas('forwardedDocuments', function($query) use ($authUserId) { // Incoming documents
                $query->where('forwarded_to', $authUserId);
            })
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function($doc) {
                // Format the month and year
                $doc->formatted_month = Carbon::create($doc->year, $doc->month, 1)->format('F Y');
                return $doc;
            });
    
        // Get document counts by month
        $documentsCountByMonth = Document::where('sender_id', $authUserId)
            ->orWhereHas('forwardedDocuments', function($query) use ($authUserId) {
                $query->where('forwarded_to', $authUserId);
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
    
        // Count documents by category
        $documentsCountByCategory = Document::where('sender_id', $authUserId)
            ->orWhereHas('forwardedDocuments', function($query) use ($authUserId) {
                $query->where('forwarded_to', $authUserId);
            })
            ->selectRaw('category, COUNT(*) as count') // Assuming 'category' is a field in your Document model
            ->groupBy('category')
            ->get();
    
        $categories = $documentsCountByCategory->pluck('category');
        $countscategories = $documentsCountByCategory->pluck('count');
    
        return view('user.dashboard.index', compact(
            'months',
            'counts',
            'pendingsCount',
            'receivedCounts',
            'forwardedCounts',
            'acceptedCounts',
            'categories',
            'countscategories',
        ));
    }
    

}
