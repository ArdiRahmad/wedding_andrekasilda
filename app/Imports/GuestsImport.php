<?php

namespace App\Imports;

use App\Models\Guest;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class GuestsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        // Logika unique_code: Jika di excel kosong, biarkan model (booted) yang handle
        // atau kita generate di sini untuk memastikan looping check berjalan.
        
        return new Guest([
            'name'            => $row['name'] ?? $row['nama'], // Support bilingua header
            'whatsapp_number' => $this->formatWhatsapp($row['whatsapp_number'] ?? $row['whatsapp']),
            'category'        => $row['category'] ?? $row['kategori'],
            'rsvp_status'     => $row['rsvp_status'] ?? 'pending',
            'pax'             => $row['pax'] ?? 1,
            'side'            => $row['side'] ?? 'groom',
            // unique_code tidak perlu diimport agar tetap auto-generate yang unik di sistem
        ]);
    }

    private function formatWhatsapp($number)
    {
        if (!$number) return null;
        // Bersihkan karakter non-numeric
        $number = preg_replace('/[^0-9]/', '', $number);
        // Jika mulai dengan 0, ganti ke 62
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        return $number;
    }
}