<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman ganti password
     */
    public function changePassword()
    {
        return view('admin.settings.change-password');
    }

    /**
     * Proses update password
     */
    public function updatePassword(Request $request)
    {
        // Validasi ketat ala Laravel 11/12
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'current_password.current_password' => 'Password lama yang Anda masukkan salah.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ]);

        // Update password user yang sedang login
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password akun Anda berhasil diperbarui!');
    }
}