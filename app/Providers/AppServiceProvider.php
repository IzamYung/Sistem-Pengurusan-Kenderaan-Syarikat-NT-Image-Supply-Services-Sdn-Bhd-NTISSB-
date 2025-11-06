<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

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
        // Share logged-in user data globally with all views
        View::composer('*', function ($view) {
            $user = null;
            if (session()->has('loginId')) {
                $user = User::where('id_pekerja', session('loginId'))->first();
            }
            $view->with('user', $user);
        });
    }
}
