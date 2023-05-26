<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        View::share('Title', 'Live laravel');
        View::composer('lecturers.index',function(\Illuminate\View\View $view) {
            $view->with('subtitle', 'Lecturers');
        });
    }
}
