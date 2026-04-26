<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $guest = '';

        if ($request->code) {
            $guest = Guest::where('unique_code', $request->code)->first();
        }
        $wishes = Guest::select('message', 'name')->where('is_wishes', 1)->get();
        return Inertia::render('Home', [
            'guest' => $guest,
            'wishes' => $wishes
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
