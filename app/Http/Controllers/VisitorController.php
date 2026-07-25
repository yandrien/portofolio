<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitorSummary;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
		// Jika bukan admin, jangan kasih lewat!
		if (!auth()->user()->is_admin) {
			return redirect('/')->with('error', 'Akses ditolak!');
		}
		
        // Ambil 50 data pengunjung terbaru dari log detail
        $visitors = Visitor::orderBy('created_at', 'desc')->paginate(50);
        
        // Ambil total statistik akumulasi (Lifetime) dari tabel VisitorSummary
        $summary = VisitorSummary::find(1);

        $totalHits   = $summary ? $summary->total_hits : 9297;
        $uniqueUsers = $summary ? $summary->total_visitors : 1856;

        // Kirim ke halaman Blade Admin
        return view('admin.visitors', compact('visitors', 'totalHits', 'uniqueUsers'));
    }
}