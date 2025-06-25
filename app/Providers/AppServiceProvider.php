<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ไม่ต้องมี parent::boot();
        // ไม่ต้องใส่ Route::middleware() ที่นี่
    }
}
