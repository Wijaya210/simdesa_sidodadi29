<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SuratPengajuan;
use App\Models\Pengaduan;

class AdminNotificationServiceProvider extends ServiceProvider
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
        // Share notification counts to the layout
        View::composer('layouts.app', function ($view) {
            // Only query if the user is authenticated and is an admin
            if (auth()->check() && auth()->user()->role == 'admin') {
                $unreadSurat = SuratPengajuan::where('is_read', false)->count();
                $unreadPengaduan = Pengaduan::where('is_read', false)->count();

                $view->with('unreadSurat', $unreadSurat)
                    ->with('unreadPengaduan', $unreadPengaduan);
            } else {
                $view->with('unreadSurat', 0)
                    ->with('unreadPengaduan', 0);
            }
        });
    }
}
