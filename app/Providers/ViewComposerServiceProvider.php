<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Language;

class ViewComposerServiceProvider extends ServiceProvider
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
        // Layout dosyalarına aktif dilleri gönder
        View::composer([
            'layout.portal.common',
            'layout.auth.common',
            'layout.end-user.common',
            'layout.portal.meeting-detail',
            'portal.register.index'
        ], function ($view) {
            $activeLanguages = Language::where('is_active', true)->get();
            $view->with('activeLanguages', $activeLanguages);
        });
    }
}
