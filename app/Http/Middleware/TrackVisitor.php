<?php
//API gratis dari ip-api.com untuk deteksi asal negara

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use App\Models\VisitorSummary; //ditambahkan tabel ringkasan pengunjung agar data visitor max 100 saja-25/07/2026 
use Illuminate\Support\Facades\Http;

class TrackVisitor
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        $today = now()->toDateString();
		
		/* STREAMING_CHUNK: Mengoptimalkan deteksi pengunjung unik menggunakan Session - 25/07/2026*/
		$sessionKey = 'has_visited_today_' . str_replace('.', '_', $ip);


		// Ambil atau inisialisasi data Summary ID = 1 (kumulatif kumulatif)
        // Nilai awal total_visitors sesuai dengan data pengunjung terakhir sebelum data diringkas
        $summary = VisitorSummary::firstOrCreate(
            ['id' => 1],
            [
                'total_visitors' => 1856, 
                'total_hits' => 9297
            ]
        );
		
		//Cek apakah di SESSION browser sudah tercatat pernah berkunjung hari ini
		$hasSessionToday = session()->get($sessionKey) === $today;

		//Cek juga di database (sebagai cadangan jika session mati/dibersihkan)
		$hasDbLogToday = Visitor::where('ip_address', $ip)->whereDate('created_at', $today)->exists();
				
        if ($hasSessionToday || $hasDbLogToday) {
			// JIKA SUDAH PERNAH (baik lewat session / db): Cukup tambah hits kumulatif
			$summary->increment('total_hits');
			
			// Update hits di log jika log database-nya masih ada
			$visitor = Visitor::where('ip_address', $ip)->whereDate('created_at', $today)->first();
			if ($visitor) {
				$visitor->increment('hits');
			}
		} else {
			// JIKA BENAR-BENAR BARU:
			// Set Session hari ini agar kunjungan berikutnya tidak dihitung unik lagi
			session()->put($sessionKey, $today);

			// Ambil asal negara dari API
			$country = 'Unknown';
			if ($ip !== '127.0.0.1' && $ip !== '::1') {
				try {
					$response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}");
					if ($response->successful()) {
						$country = $response->json()['country'] ?? 'Unknown';
					}
				} catch (\Exception $e) {}
			}

			// Simpan log detail baru
			Visitor::create([
				'ip_address'   => $ip,
				'country'      => $country,
				'page_visited' => $request->fullUrl(),
				'browser'      => $request->header('User-Agent'),
				'hits'         => 1,
			]);

			// Tambahkan statistik kumulatif
			$summary->increment('total_visitors');
			$summary->increment('total_hits');
		}

		//AUTO-CLEANUP LOG DETAIL (Maksimal hanya simpan 100 log terbaru)
		$threshold = Visitor::orderBy('id', 'desc')->skip(99)->first();
		if ($threshold) {
			Visitor::where('id', '<', $threshold->id)->delete();
		}

		
        return $next($request);
    }
}
