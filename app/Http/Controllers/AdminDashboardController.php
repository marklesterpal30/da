<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function showApproverDashboard()
    {
        $pendingDocumentsCount = Document::where('status', 'pending')->count();
        $receivedDocumentsCount = Document::where('status', 'received')->count();
        $forwardedDocumentsCount = Document::where('status', 'forwarded')->count(); // Fixed typo
        $acceptedDocumentsCount = Document::where('status', 'accepted')->count();

        $activeDocuments = Document::where('inactive_years', '>', now())->count();
        $inactiveDocuments = Document::where('inactive_years', '<', now())->count();

        $totalUsers = User::where('role', 'office')->count();

        $documentsCountByMonth = Document::where('recieved_by', Auth::id())
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        $categories = Document::select('category', \DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        $months = [];
        $counts = [];

        // Fill arrays with counts for each month
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('F', mktime(0, 0, 0, $i, 1));
            $counts[] = $documentsCountByMonth->where('month', $i)->first()->count ?? 0;
        }

        $recieved_by = Auth::id();
        $incomingCount = Document::where('recieved_by', $recieved_by)
            ->where('status', 'forwarded')
            ->count();

        return view('admin.dashboard.index', compact(
            'months',
            'counts',
            'incomingCount',
            'totalUsers',
            'activeDocuments',
            'inactiveDocuments',
            'categories',
            'pendingDocumentsCount',
            'receivedDocumentsCount',
            'forwardedDocumentsCount',
            'acceptedDocumentsCount'
        ));
    }
}
