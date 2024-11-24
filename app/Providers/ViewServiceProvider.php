<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ForwardedDocument;
use App\Models\Document; // Make sure to import the Document model
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Share data with office layout
        View::composer('office.layouts.master', function ($view) {
            // Get the authenticated user's ID
            $userId = Auth::id();
            
            // If a user is authenticated, get the office incoming count
            if ($userId) {
                $officeIncomingCount = ForwardedDocument::where('forwarded_to', $userId)
                    ->whereNull('accepted_date')
                    ->count();

                // Pass the count to the view
                $view->with('officeIncomingCount', $officeIncomingCount);
            }
        });

        View::composer('user.layouts.master', function ($view) {
            // Get the authenticated user's ID
            $userId = Auth::id();
            
            // If a user is authenticated, get the office incoming count
                $userIncomingCount = ForwardedDocument::where('forwarded_to', $userId)
                    ->whereNull('accepted_date')
                    ->count();

                // Pass the count to the view
                $view->with('userIncomingCount', $userIncomingCount);
        });

        // Share data with admin layout
        View::composer('admin.layouts.master', function ($view) {
            $userId = Auth::id();

            $incomingCountRecordsOffice = Document::where('status', 'pending')
            ->whereIn('type', ['incoming', 'outgoing']) // Check for both types
            ->where('recieved_by', 2)
            ->where('sender_id', '!=', $userId)
                ->count();

            // Pass the count to the view
            $view->with('incomingCountRecordsOffice', $incomingCountRecordsOffice);
        });
    }
}
