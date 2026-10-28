<?php

namespace App\Providers;

use App\Services\ThemeService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ThemeService::class, function () {
            return new ThemeService();
        });
    }

    public function boot(ThemeService $themeService): void
    {
        View::composer('*', function ($view) use ($themeService) {
            $view->with('themeColors', $themeService->colors());
        });
    }
}
