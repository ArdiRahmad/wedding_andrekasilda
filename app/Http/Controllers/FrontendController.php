<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontendController extends Controller
{
    // public function index($code = null)
    // {
    //     $type = 'mrn';
    //     $guest = '';
    //     if ($code) {
    //         if ($code == 'admin') {
    //             return redirect()->route('admin.index');
    //         }
    //         $guest = Guest::where('unique_code', $code)->first();
    //         if ($guest && $guest->tag) {
    //             $type = $guest->tag;
    //         } else {
    //             return redirect()->to('/');
    //         }
    //     }

    //     $wishes = Guest::select('message', 'name')->where('is_wishes', 1)->get();
    //     return Inertia::render('Home', [
    //         'guest' => $guest,
    //         'wishes' => $wishes,
    //         'type' => $type
    //     ]);
    // }
    public function index($code = null)
    {
        // Default tipe jika diakses tanpa URL parameter (root '/')
        $type = 'mrn';
        $guest = null; // Lebih aman menggunakan null daripada string kosong untuk object

        if ($code) {
            // 1. Cek apakah itu akses admin
            if ($code === 'admin') {
                return redirect()->route('admin.index');
            }

            // 2. Cek apakah itu akses link statis tipe undangan
            if (in_array($code, ['aft', 'mrn'])) {
                $type = $code;
            } 
            // 3. Jika bukan keduanya, asumsikan itu adalah kode tamu unik
            else {
                $guest = Guest::where('unique_code', $code)->first();
                
                if ($guest && $guest->tag) {
                    $type = $guest->tag;
                } else {
                    // Tamu tidak ditemukan, kembalikan ke beranda
                    return redirect()->to('/');
                }
            }
        }

        // Ambil data ucapan
        $wishes = Guest::select('message', 'name')->where('is_wishes', 1)->get();
        
        // Render ke frontend (Vue/React via Inertia)
        return Inertia::render('Home', [
            'guest' => $guest,
            'wishes' => $wishes,
            'type' => $type
        ]);
    }
    
    public function rsvp(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rsvp_status' => 'required',
            'side' => 'required',
            'message' => 'nullable',
            'gift_image' => 'nullable',
        ]);

        try {
            $data = $request->except('gift_image');
            if ($request->gift_image) {
                $image = $request->file('gift_image');
                $file_path = $this->storeRenameImage($image, "gift_image");

                $data['gift_image'] = $file_path;
            }

            Guest::updateOrCreate(
                ['unique_code' => $request->unique_code],
                $data
            );
            return redirect()->route('auth.login')->with([
                'message' => 'Password berhasil diperbarui',
                'type' => 'success'
            ]);
        } catch (\Throwable $th) {
            return back()->with([
                'message' => $th->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function storeRenameImage($file, $path)
    {
        $original_extension_name = $file->getClientOriginalExtension();
        $fileName = md5(microtime()) . "." . $original_extension_name;
        $file->storeAs($path, $fileName, 'public');
        $image = 'storage/' . $path . "/" . $fileName;

        return $image;
    }
}
