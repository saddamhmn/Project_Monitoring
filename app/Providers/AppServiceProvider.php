<?php

namespace App\Providers;

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
        // Force HTTPS HANYA di production environment
        if (!app()->runningInConsole() && !in_array(request()->getHost(), ['localhost', '127.0.0.1'])) {
            URL::forceScheme('https');
            
        }else {
            URL::forceScheme('http');
        }
    
        
        // ATAU force HTTPS hanya jika bukan localhost/127.0.0.1
        // if (!app()->runningInConsole() && !in_array(request()->getHost(), ['localhost', '127.0.0.1'])) {
        //     URL::forceScheme('https');
        // }
    }
}