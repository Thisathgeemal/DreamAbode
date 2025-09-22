<?php
namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share unread notification count with all navigation views
        $navigationViews = [
            'includes.admin-navigation',
            'includes.agent-navigation',
            'includes.member-navigation',
        ];
        View::composer($navigationViews, function ($view) {
            $count = 0;
            if (Auth::check()) {
                $count = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            }
            $view->with('unreadNotificationCount', $count);
        });
    }
}
