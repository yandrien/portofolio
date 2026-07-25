<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Visitor;        // Log detail (dipakai untuk mengambil negara)
use App\Models\VisitorSummary; // 25/07/2026

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Bagikan data ke file footer di semua halaman secara otomatis
        View::composer('*', function ($view) {
            // 1. Ambil statistik akumulasi Lifetime dari tabel VisitorSummary (ID = 1)
            $summary = VisitorSummary::find(1);

            // Gunakan angka akumulasi lifetime, bukan hitung baris log
            $unique_visitors = $summary ? $summary->total_visitors : 1856;
            $total_hits      = $summary ? $summary->total_hits : 9297;

            // 2. Ambil negara terbanyak dari log detail terbaru
            $top_countries = Visitor::select('country')
                                     ->orderBy('hits', 'desc')
                                     ->limit(1)
                                     ->get();

            $view->with([
                'unique_visitors' => $unique_visitors,
                'total_hits'      => $total_hits,
                'top_countries'   => $top_countries
            ]);
        });
    }
}