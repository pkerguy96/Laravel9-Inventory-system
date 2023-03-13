<?php

namespace App\Providers;

use App\Events\ProductQuantityUpdated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\notifications;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Retrieve all unread notifications for the authenticated user
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = Notifications::where('is_read', false)
                    ->where('user_id', $user->id)
                    ->get();
                View::share('notifications', $notifications);
            }
        });
        Schema::defaultStringLength(191);

        view()->composer('admin.body.header', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });
    }
}
