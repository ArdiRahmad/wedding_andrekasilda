<?php

namespace App\Http\Controllers\Admin;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\GuestsImport;
use App\Exports\GuestsExport;
use App\Models\WaTemplate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuestTemplateExport;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::latest()->paginate(10);
        return view('admin.guests.index', compact('guests'));
    }

    public function create()
    {
        return view('admin.guests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'category' => 'nullable|string',
            'side' => 'required|in:groom,bride',
            'pax' => 'required|integer|min:1', // Validasi minimal 1
        ]);

        Guest::create($validated);

        return redirect()->route('admin.guests.index')->with('success', 'Tamu berhasil ditambahkan!');
    }

    public function edit(Guest $guest)
    {
        return view('admin.guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'category' => 'nullable|string',
            'rsvp_status' => 'required|in:pending,hadir,tidak_hadir',
            'pax' => 'integer|min:0',
            'side' => 'required|in:groom,bride',
        ]);

        $guest->update($validated);

        return redirect()->route('admin.guests.index')->with('success', 'Data tamu diperbarui!');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('admin.guests.index')->with('success', 'Tamu dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new GuestsImport, $request->file('file'));
            return back()->with('success', 'Import tamu berhasil dilakukan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new GuestsExport, 'rekap-tamu-'.date('Y-m-d').'.xlsx');
    }

    public function downloadTemplate()
    {
        return Excel::download(new GuestTemplateExport, 'template_import_tamu.xlsx');
    }

    // Menampilkan daftar moderasi ucapan
    public function wishes()
    {
        $wishes = Guest::whereNotNull('message')->where('message', '!=', '')->latest()->get();
        return view('admin.guests.wishes', compact('wishes'));
    }

    // Toggle status via AJAX agar admin lebih cepat kerja
    public function toggleWishes(Request $request, Guest $guest)
    {
        $guest->update(['is_wishes' => !$guest->is_wishes]);
        return response()->json(['success' => true, 'new_status' => $guest->is_wishes]);
    }

    public function broadcast()
    {
        $guests = Guest::where('is_wa_sent', false)
                        ->whereNotNull('whatsapp_number')
                        ->latest()
                        ->get();

        // Ambil template yang aktif
        $template = \App\Models\WaTemplate::where('is_active', true)->first();
        
        // Fallback: Jika admin belum buat template atau tidak ada yang aktif
        $rawMessage = $template ? $template->message : "Halo {name}, cek undangan kami di {url}";

        // PASTIKAN rawMessage dimasukkan ke compact
        return view('admin.guests.broadcast', compact('guests', 'rawMessage'));
    }

    // Method untuk update status via AJAX setelah kirim WA
    public function markAsSent(Guest $guest)
    {
        $guest->update(['is_wa_sent' => true]);
        return response()->json(['success' => true]);
    }
}