<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaTemplate;
use Illuminate\Http\Request;

class WaTemplateController extends Controller
{
    public function index()
    {
        $templates = WaTemplate::latest()->get();
        return view('admin.wa-templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = $request->all();
        
        // Cek jika ini template pertama, otomatis aktifkan
        if (WaTemplate::count() == 0) {
            $data['is_active'] = true;
        } else {
            $data['is_active'] = $request->has('is_active');
        }

        $template = WaTemplate::create($data);

        // Jika yang baru dibuat ini aktif, nonaktifkan yang lain
        if ($template->is_active) {
            WaTemplate::where('id', '!=', $template->id)->update(['is_active' => false]);
        }

        return back()->with('success', 'Template berhasil ditambahkan.');
    }

    public function setActive(WaTemplate $wa_template)
    {
        // Set semua jadi false dulu
        WaTemplate::query()->update(['is_active' => false]);

        // Aktifkan yang dipilih
        $wa_template->update(['is_active' => true]);

        return back()->with('success', 'Template "' . $wa_template->title . '" sekarang aktif.');
    }

    public function destroy(WaTemplate $wa_template)
    {
        if ($wa_template->is_active) {
            return back()->with('error', 'Template aktif tidak boleh dihapus. Aktifkan template lain dulu.');
        }

        $wa_template->delete();
        return back()->with('success', 'Template berhasil dihapus.');
    }
}