<?php
namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // You can map events to listener classes here if needed
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        // Login listener
        Event::listen(Login::class, function ($event) {
            $user = $event->user;

            $token = $user->createToken('auth_token')->plainTextToken;

            session(['auth_token' => $token]);
        });

        // Logout listener
        Event::listen(Logout::class, function ($event) {
            $user = $event->user;

            if ($user) {
                $user->tokens()->where('name', 'auth_token')->delete();
            }

            Session::forget('auth_token');
        });

    }
}
