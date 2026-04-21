<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Total seluruh tamu di database
        // $totalTamu = Guest::count();
        $totalTamu = 1;

        // 2. Jumlah tamu yang sudah dikirimi pesan WA
        // $waTerkirim = Guest::where('is_wa_sent', true)->count();
        $waTerkirim = 1;

        // 3. Jumlah yang sudah mengisi RSVP (Hadir atau Tidak Hadir)
        // $sudahIsi = Guest::where('rsvp_status', '!=', 'pending')->count();
        $sudahIsi = 1;

        // 4. Jumlah yang belum mengisi RSVP (Masih Pending)
        // $belumIsi = Guest::where('rsvp_status', 'pending')->count();
        $belumIsi = 1;

        return view('admin.index', compact(
            'totalTamu',
            'waTerkirim',
            'sudahIsi',
            'belumIsi'
        ));
    }
}