<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        // Share the authenticated user (from either guard) with all views
        View::composer('*', function ($view) {
            $currentUser = Auth::guard('web')->check()
                ? Auth::guard('web')->user()
                : (Auth::guard('cooperative')->check()
                    ? Auth::guard('cooperative')->user()
                    : null);

            $view->with('currentUser', $currentUser);
        });
    }
}
