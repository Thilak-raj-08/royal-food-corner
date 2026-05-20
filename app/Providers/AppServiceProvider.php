<?php

namespace App\Providers;

use App\View\Composers\GlobalComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', GlobalComposer::class);

        if (env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
